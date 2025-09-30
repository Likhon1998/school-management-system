<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user')->paginate(10);
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        $users = User::all(); 
        return view('teachers.create', compact('users'));
    }

    public function store(Request $request)
    {   
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'teacher_name' => 'required|max:100',
            'employee_id' => 'required|unique:teachers,employee_id',
            'joining_date' => 'required|date',
            'designation' => 'required|max:50',
            'qualification' => 'nullable|max:200',
            'experience' => 'nullable|integer',
            'salary' => 'nullable|numeric',
            'status' => 'required|in:active,inactive,resigned',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('teachers', 'public');
        }

        Teacher::create([
            'user_id' => $request->user_id,
            'teacher_name' => $request->teacher_name,
            'employee_id' => $request->employee_id,
            'joining_date' => $request->joining_date,
            'designation' => $request->designation,
            'qualification' => $request->qualification ?? null,
            'experience' => $request->experience ?? 0,
            'salary' => $request->salary ?? 0,
            'status' => $request->status,
            'photo' => $photoPath,
        ]);

        return redirect()->route('teachers.index')->with('success', 'Teacher added successfully.');
    }

    public function show(Teacher $teacher)
    {
        return view('teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        $users = User::all();
        return view('teachers.edit', compact('teacher', 'users'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'teacher_name' => 'required|max:100',
            'employee_id' => 'required|unique:teachers,employee_id,' . $teacher->id,
            'joining_date' => 'required|date',
            'designation' => 'required|max:50',
            'qualification' => 'nullable|max:200',
            'experience' => 'nullable|integer',
            'salary' => 'nullable|numeric',
            'status' => 'required|in:active,inactive,resigned',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only([
            'user_id',
            'teacher_name',
            'employee_id',
            'joining_date',
            'designation',
            'qualification',
            'experience',
            'salary',
            'status',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($teacher->photo && Storage::disk('public')->exists($teacher->photo)) {
                Storage::disk('public')->delete($teacher->photo);
            }

            $data['photo'] = $request->file('photo')->store('teachers', 'public');
        } else {
            $data['photo'] = $teacher->photo; // keep old photo if no new file
        }

        $teacher->update($data);

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        // Delete photo file if exists
        if ($teacher->photo && Storage::disk('public')->exists($teacher->photo)) {
            Storage::disk('public')->delete($teacher->photo);
        }

        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}

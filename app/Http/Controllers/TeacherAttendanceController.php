<?php

namespace App\Http\Controllers;

use App\Models\TeacherAttendance;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherAttendanceController extends Controller
{
    public function index()
    {
        $teacherAttendances = TeacherAttendance::with('teacher')
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('teacher_attendance.index', compact('teacherAttendances'));
    }

    public function create()
    {
        $teachers = Teacher::all();
        return view('teacher_attendance.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late,half_day',
            'remarks' => 'nullable|string',
        ]);

        TeacherAttendance::create($validated);

        return redirect()->route('teacher_attendance.index')
                         ->with('success', 'Teacher attendance marked successfully.');
    }

    public function edit(TeacherAttendance $teacherAttendance)
    {
        $teachers = Teacher::all();
        return view('teacher_attendance.edit', compact('teacherAttendance', 'teachers'));
    }

    public function update(Request $request, TeacherAttendance $teacherAttendance)
    { 
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late,half_day',
            'remarks' => 'nullable|string',
        ]);

        $teacherAttendance->update($validated);

        return redirect()->route('teacher_attendance.index')
                         ->with('success', 'Teacher attendance updated successfully.');
    }

    public function destroy(TeacherAttendance $teacherAttendance)
    {
        $teacherAttendance->delete();

        return redirect()->route('teacher_attendance.index')
                         ->with('success', 'Teacher attendance deleted successfully.');
    }
}

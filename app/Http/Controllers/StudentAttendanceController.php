<?php

namespace App\Http\Controllers;

use App\Models\StudentAttendance;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class StudentAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studentAttendances = StudentAttendance::with(['student', 'teacher'])
                                ->orderBy('date', 'desc')
                                ->paginate(10);

        return view('student_attendance.index', compact('studentAttendances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        $teachers = Teacher::all(); // For "marked by" dropdown
        return view('student_attendance.create', compact('students', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late,half_day',
            'remarks' => 'nullable|string',
            'marked_by' => 'required|exists:teachers,id',
        ]);

        StudentAttendance::create($validated);

        return redirect()->route('student_attendance.index')
                         ->with('success', 'Attendance marked successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentAttendance $studentAttendance)
    {
        $students = Student::all();
        $teachers = Teacher::all();
        return view('student_attendance.edit', compact('studentAttendance', 'students', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudentAttendance $studentAttendance)
    {
        // Ensure 'marked_by' is included (hidden input)
        $request->merge([
            'marked_by' => $request->marked_by ?? $studentAttendance->marked_by
        ]);

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late,half_day',
            'remarks' => 'nullable|string',
            'marked_by' => 'required|exists:teachers,id',
        ]);

        $studentAttendance->update($validated);

        return redirect()->route('student_attendance.index')
                         ->with('success', 'Attendance updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentAttendance $studentAttendance)
    {
        $studentAttendance->delete();

        return redirect()->route('student_attendance.index')
                         ->with('success', 'Attendance deleted successfully.');
    }
}

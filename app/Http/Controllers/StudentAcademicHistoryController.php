<?php

namespace App\Http\Controllers;

use App\Models\StudentAcademicHistory;
use App\Models\Student;
use App\Models\AcademicYear;
use App\Models\ClassModel;
use App\Models\Section;
use Illuminate\Http\Request;

class StudentAcademicHistoryController extends Controller
{
    public function index()
    {
        $histories = StudentAcademicHistory::with(['student', 'academicYear', 'class', 'section'])->paginate(10);
        return view('student_academic_history.index', compact('histories'));
    }

    public function create()
    {
        $students = Student::where('status', 'active')->get();
        $academicYears = AcademicYear::where('status', 'active')->get();
        $classes = ClassModel::where('status', 'active')->get();
        $sections = Section::all();
        return view('student_academic_history.create', compact('students', 'academicYears', 'classes', 'sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'student_name' => 'required|string|max:100',
            'academic_year_id' => 'required|exists:academic_years,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'roll_number' => 'nullable|integer|min:1',
            'promotion_status' => 'required|in:promoted,failed,transferred',
        ]);

        StudentAcademicHistory::create($request->all());

        return redirect()->route('student_academic_history.index')
                         ->with('success', 'Academic history added successfully.');
    }

    public function edit(StudentAcademicHistory $studentAcademicHistory)
    {
        $students = Student::where('status', 'active')->get();
        $academicYears = AcademicYear::where('status', 'active')->get();
        $classes = ClassModel::where('status', 'active')->get();
        $sections = Section::all();
        return view('student_academic_history.edit', compact('studentAcademicHistory', 'students', 'academicYears', 'classes', 'sections'));
    }

    public function update(Request $request, StudentAcademicHistory $studentAcademicHistory)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'student_name' => 'required|string|max:100',
            'academic_year_id' => 'required|exists:academic_years,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'roll_number' => 'nullable|integer|min:1',
            'promotion_status' => 'required|in:promoted,failed,transferred',
        ]);

        $studentAcademicHistory->update($request->all());

        return redirect()->route('student_academic_history.index')
                         ->with('success', 'Academic history updated successfully.');
    }

    public function destroy(StudentAcademicHistory $studentAcademicHistory)
    {
        $studentAcademicHistory->delete();
        return redirect()->route('student_academic_history.index')
                         ->with('success', 'Academic history deleted successfully.');
    }
}

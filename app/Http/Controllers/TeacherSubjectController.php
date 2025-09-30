<?php

namespace App\Http\Controllers;

use App\Models\TeacherSubject;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\ClassModel;
use App\Models\Section;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class TeacherSubjectController extends Controller
{
    // List all teacher subjects
    public function index()
    {
        $teacherSubjects = TeacherSubject::with(['teacher', 'subject', 'class', 'section', 'academicYear'])->paginate(10);
        return view('teacher_subjects.index', compact('teacherSubjects'));
    }

    // Show create form
    public function create()
    {
        $teachers = Teacher::all();
        $subjects = Subject::all();
        $classes = ClassModel::all();
        $sections = Section::all();
        $academic_years = AcademicYear::all(); // snake_case to match Blade

        return view('teacher_subjects.create', compact('teachers', 'subjects', 'classes', 'sections', 'academic_years'));
    }

    // Store new record
    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        $teacher = Teacher::find($request->teacher_id);

        TeacherSubject::create([
            'teacher_id' => $request->teacher_id,
            'teacher_name' => $teacher->teacher_name, 
            'subject_id' => $request->subject_id,
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'academic_year_id' => $request->academic_year_id,
        ]);

        return redirect()->route('teacher_subjects.index')->with('success', 'Teacher Subject assigned successfully.');
    }

    // Show single record
    public function show(TeacherSubject $teacherSubject)
    {
        return view('teacher_subjects.show', compact('teacherSubject'));
    }

    // Show edit form
    public function edit(TeacherSubject $teacherSubject)
    {
        $teachers = Teacher::all();
        $subjects = Subject::all();
        $classes = ClassModel::all();
        $sections = Section::all();
        $academic_years = AcademicYear::all(); // snake_case to match Blade

        return view('teacher_subjects.edit', compact('teacherSubject', 'teachers', 'subjects', 'classes', 'sections', 'academic_years'));
    }

    // Update record
    public function update(Request $request, TeacherSubject $teacherSubject)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        $teacher = Teacher::find($request->teacher_id);

        $teacherSubject->update([
            'teacher_id' => $request->teacher_id,
            'teacher_name' => $teacher->teacher_name, 
            'subject_id' => $request->subject_id,
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'academic_year_id' => $request->academic_year_id,
        ]);

        return redirect()->route('teacher_subjects.index')->with('success', 'Teacher Subject updated successfully.');
    }

    // Delete record
    public function destroy(TeacherSubject $teacherSubject)
    {
        $teacherSubject->delete();
        return redirect()->route('teacher_subjects.index')->with('success', 'Teacher Subject deleted successfully.');
    }
}

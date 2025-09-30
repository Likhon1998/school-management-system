<?php

namespace App\Http\Controllers;

use App\Models\ClassTeacher;
use App\Models\Teacher;
use App\Models\ClassModel;
use App\Models\Section;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class ClassTeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classTeachers = ClassTeacher::with(['teacher', 'class', 'section', 'academicYear'])->paginate(10);

        return view('class_teachers.index', compact('classTeachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = Teacher::all();
        $classes = ClassModel::all();
        $sections = Section::all();
        $academicYears = AcademicYear::all();

        return view('class_teachers.create', compact('teachers', 'classes', 'sections', 'academicYears'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
   
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        ClassTeacher::create([
            'teacher_id' => $request->teacher_id,
            'teacher_name' => Teacher::find($request->teacher_id)->teacher_name ?? null,
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'academic_year_id' => $request->academic_year_id,
        ]);

        return redirect()->route('class_teachers.index')->with('success', 'Class Teacher assigned successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassTeacher $classTeacher)
    {
        $teachers = Teacher::all();
        $classes = ClassModel::all();
        $sections = Section::all();
        $academicYears = AcademicYear::all();

        return view('class_teachers.edit', compact('classTeacher', 'teachers', 'classes', 'sections', 'academicYears'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassTeacher $classTeacher)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        $classTeacher->update([
            'teacher_id' => $request->teacher_id,
            'teacher_name' => Teacher::find($request->teacher_id)->teacher_name ?? null,
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'academic_year_id' => $request->academic_year_id,
        ]);

        return redirect()->route('class_teachers.index')->with('success', 'Class Teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassTeacher $classTeacher)
    {
        $classTeacher->delete();

        return redirect()->route('class_teachers.index')->with('success', 'Class Teacher deleted successfully.');
    }
}

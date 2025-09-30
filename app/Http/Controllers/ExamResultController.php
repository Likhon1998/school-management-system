<?php

namespace App\Http\Controllers;

use App\Models\ExamResult;
use App\Models\Student;
use App\Models\Examination;
use App\Models\Subject;
use Illuminate\Http\Request;

class ExamResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $examResults = ExamResult::with(['student', 'examination', 'subject'])
                                 ->orderBy('id', 'desc')
                                 ->paginate(10);

        return view('exam_results.index', compact('examResults'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        $examinations = Examination::all();
        $subjects = Subject::all();

        return view('exam_results.create', compact('students', 'examinations', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'examination_id' => 'required|exists:examinations,id',
            'subject_id' => 'required|exists:subjects,id',
            'obtained_marks' => 'required|numeric|min:0',
            'full_marks' => 'required|numeric|min:1',
            'grade' => 'required|string|max:5',
            'gpa' => 'required|numeric|between:0,5',
            'remarks' => 'nullable|string',
        ]);

        ExamResult::create($validated);

        return redirect()->route('exam_results.index')
                         ->with('success', 'Exam result added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExamResult $examResult)
    {
        $students = Student::all();
        $examinations = Examination::all();
        $subjects = Subject::all();

        return view('exam_results.edit', compact('examResult', 'students', 'examinations', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExamResult $examResult)
    {
        $validated = $request->validate([
            'obtained_marks' => 'required|numeric|min:0',
            'full_marks' => 'required|numeric|min:1',
            'grade' => 'required|string|max:5',
            'gpa' => 'required|numeric|between:0,5',
            'remarks' => 'nullable|string',
        ]);

        $examResult->update($validated);

        return redirect()->route('exam_results.index')
                         ->with('success', 'Exam result updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExamResult $examResult)
    {
        $examResult->delete();

        return redirect()->route('exam_results.index')
                         ->with('success', 'Exam result deleted successfully.');
    }
}

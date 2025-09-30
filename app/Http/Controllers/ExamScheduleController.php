<?php

namespace App\Http\Controllers;

use App\Models\ExamSchedule;
use App\Models\Examination;
use App\Models\Subject;
use App\Models\ClassModel;
use Illuminate\Http\Request;

class ExamScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $examSchedules = ExamSchedule::with(['examination', 'subject', 'class'])
                            ->orderBy('exam_date', 'asc')
                            ->paginate(10);

        return view('exam_schedules.index', compact('examSchedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $examinations = Examination::all();
        $subjects = Subject::all();
        $classes = ClassModel::all();

        return view('exam_schedules.create', compact('examinations', 'subjects', 'classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'examination_id' => 'required|exists:examinations,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'exam_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'full_marks' => 'required|numeric',
            'pass_marks' => 'required|numeric',
        ]);

        ExamSchedule::create($validated);

        return redirect()->route('exam_schedules.index')
                         ->with('success', 'Exam schedule created successfully.');
    }

    
    public function edit(ExamSchedule $examSchedule)
    {
        $examinations = Examination::all();
        $subjects = Subject::all();
        $classes = ClassModel::all();

        return view('exam_schedules.edit', compact('examSchedule', 'examinations', 'subjects', 'classes'));
    }

    
    public function update(Request $request, ExamSchedule $examSchedule)
    {
        $validated = $request->validate([
            'examination_id' => 'required|exists:examinations,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'exam_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'full_marks' => 'required|numeric',
            'pass_marks' => 'required|numeric',
        ]);

        $examSchedule->update($validated);

        return redirect()->route('exam_schedules.index')
                         ->with('success', 'Exam schedule updated successfully.');
    }

  
    public function destroy(ExamSchedule $examSchedule)
    {
        $examSchedule->delete();

        return redirect()->route('exam_schedules.index')
                         ->with('success', 'Exam schedule deleted successfully.');
    }
}

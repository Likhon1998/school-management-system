<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\ClassModel;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('classModel')->paginate(10);
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        $classes = ClassModel::where('status', 'active')->get();
        return view('subjects.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_name' => 'required|string|max:100',
            'subject_code' => 'required|string|max:20|unique:subjects,subject_code',
            'class_id' => 'required|exists:classes,id',
            'is_compulsory' => 'required|boolean',
        ]);

        Subject::create($request->all());

        return redirect()->route('subjects.index')
                         ->with('success', 'Subject created successfully.');
    }

    public function edit(Subject $subject)
    {
        $classes = ClassModel::where('status', 'active')->get();
        return view('subjects.edit', compact('subject', 'classes'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'subject_name' => 'required|string|max:100',
            'subject_code' => "required|string|max:20|unique:subjects,subject_code,{$subject->id}",
            'class_id' => 'required|exists:classes,id',
            'is_compulsory' => 'required|boolean',
        ]);

        $subject->update($request->all());

        return redirect()->route('subjects.index')
                         ->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')
                         ->with('success', 'Subject deleted successfully.');
    }
}

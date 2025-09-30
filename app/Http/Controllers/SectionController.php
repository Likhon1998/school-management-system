<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\ClassModel;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::with('class')->paginate(10);
        return view('sections.index', compact('sections'));
    }

    public function create()
    {
        $classes = ClassModel::where('status', 'active')->get();
        return view('sections.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_name' => 'required|string|max:10',
            'capacity' => 'nullable|integer|min:1',
            'room_number' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        Section::create($request->all());

        return redirect()->route('sections.index')
                         ->with('success', 'Section created successfully.');
    }

    public function edit(Section $section)
    {
        $classes = ClassModel::where('status', 'active')->get();
        return view('sections.edit', compact('section', 'classes'));
    }

    public function update(Request $request, Section $section)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_name' => 'required|string|max:10',
            'capacity' => 'nullable|integer|min:1',
            'room_number' => 'nullable|string|max:20',
        ]);

        $section->update($request->all());

        return redirect()->route('sections.index')
                         ->with('success', 'Section updated successfully.');
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('sections.index')
                         ->with('success', 'Section deleted successfully.');
    }
}

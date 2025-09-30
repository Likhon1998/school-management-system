<?php
namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    // Display list of classes
    public function index()
    {
        $classes = ClassModel::latest()->paginate(10); // pagination
        return view('classes.index', compact('classes'));
    }

    // Show form to create a new class
    public function create()
    {
        return view('classes.create');
    }

    // Store new class
    public function store(Request $request)
    {
        $request->validate([
            'class_name' => 'required|string|max:20',
            'class_numeric' => 'nullable|integer',
            'status' => 'required|in:active,inactive',
        ]);

        ClassModel::create($request->all());

        return redirect()->route('classes.index')->with('success', 'Class added successfully.');
    }

    // Show form to edit an existing class
    public function edit(ClassModel $class)
    {
        return view('classes.edit', compact('class'));
    }

    // Update existing class
    public function update(Request $request, ClassModel $class)
    {
        $request->validate([
            'class_name' => 'required|string|max:20',
            'class_numeric' => 'nullable|integer',
            'status' => 'required|in:active,inactive',
        ]);

        $class->update($request->all());

        return redirect()->route('classes.index')->with('success', 'Class updated successfully.');
    }

    // Delete a class
    public function destroy(ClassModel $class)
    {
        $class->delete();
        return redirect()->route('classes.index')->with('success', 'Class deleted successfully.');
    }
}

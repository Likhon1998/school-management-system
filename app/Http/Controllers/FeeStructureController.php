<?php

namespace App\Http\Controllers;

use App\Models\FeeStructure;
use App\Models\ClassModel;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
    /**
     * Display a listing of the fee structures.
     */
    public function index()
    {
        $feeStructures = FeeStructure::with(['class', 'academicYear'])->get();
        return view('fee_structures.index', compact('feeStructures'));
    }

    /**
     * Show the form for creating a new fee structure.
     */
    public function create()
    {
        $classes = ClassModel::all();
        $academicYears = AcademicYear::all();
        return view('fee_structures.create', compact('classes', 'academicYears'));
    }

    /**
     * Store a newly created fee structure.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'fee_type' => 'required|in:monthly,admission,exam,annual',
            'amount' => 'required|numeric',
            'due_date' => 'nullable|date',
            'month' => 'nullable|in:Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec',
            'exam_name' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);

        FeeStructure::create($request->all());

        return redirect()->route('fee_structures.index')
                         ->with('success', 'Fee structure created successfully.');
    }

    /**
     * Show the form for editing the specified fee structure.
     */
    public function edit(FeeStructure $feeStructure)
    {
        $classes = ClassModel::all();
        $academicYears = AcademicYear::all();
        return view('fee_structures.edit', compact('feeStructure', 'classes', 'academicYears'));
    }

    /**
     * Update the specified fee structure.
     */
    public function update(Request $request, FeeStructure $feeStructure)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'fee_type' => 'required|in:monthly,admission,exam,annual',
            'amount' => 'required|numeric',
            'due_date' => 'nullable|date',
            'month' => 'nullable|in:Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec',
            'exam_name' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);

        $feeStructure->update($request->all());

        return redirect()->route('fee_structures.index')
                         ->with('success', 'Fee structure updated successfully.');
    }

    /**
     * Remove the specified fee structure.
     */
    public function destroy(FeeStructure $feeStructure)
    {
        $feeStructure->delete();
        return redirect()->route('fee_structures.index')
                         ->with('success', 'Fee structure deleted successfully.');
    }
}

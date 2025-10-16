<?php

namespace App\Http\Controllers;

use App\Models\FeeStructure;
use App\Models\ClassModel;
use App\Models\AcademicYear;
use App\Models\Student;
use App\Models\StudentFee;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
    public function index()
    {
        $feeStructures = FeeStructure::with(['class', 'academicYear'])->get();
        return view('fee_structures.index', compact('feeStructures'));
    }

    public function create()
    {
        $classes = ClassModel::all();
        $academicYears = AcademicYear::all();
        return view('fee_structures.create', compact('classes', 'academicYears'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'fee_type' => 'required|in:monthly,admission,exam,annual',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'nullable|date',
            'month' => 'nullable|in:Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec',
            'exam_name' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);

        // Prevent duplicate fee structure
        $exists = FeeStructure::where('class_id', $request->class_id)
            ->where('academic_year_id', $request->academic_year_id)
            ->where('fee_type', $request->fee_type)
            ->where('month', $request->month)
            ->exists();

        if ($exists) {
            return redirect()->back()->withInput()->withErrors([
                'duplicate' => 'A fee structure for this Class, Year, Type, and Month already exists.'
            ]);
        }

        // Create FeeStructure
        $feeStructure = FeeStructure::create([
            'class_id' => $request->class_id,
            'academic_year_id' => $request->academic_year_id,
            'fee_type' => $request->fee_type,
            'month' => $request->month,
            'exam_name' => $request->exam_name,
            'description' => $request->description,
            'amount' => $request->amount,
            'due_date' => $request->due_date,
        ]);

        // Assign fee to all students, avoid duplicates
        $students = Student::where('class_id', $request->class_id)->get();

        foreach ($students as $student) {
            // Only create if not exists
            StudentFee::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'fee_structure_id' => $feeStructure->id,
                ],
                [
                    'amount' => $feeStructure->amount,
                    'amount_paid' => 0,
                    'status' => 'pending',
                    'due_date' => $feeStructure->due_date,
                ]
            );
        }

        return redirect()->route('fee_structures.index')
                         ->with('success', 'Fee structure created and assigned to students successfully.');
    }

    public function edit(FeeStructure $feeStructure)
    {
        $classes = ClassModel::all();
        $academicYears = AcademicYear::all();
        return view('fee_structures.edit', compact('feeStructure', 'classes', 'academicYears'));
    }

    public function update(Request $request, FeeStructure $feeStructure)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'fee_type' => 'required|in:monthly,admission,exam,annual',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'nullable|date',
            'month' => 'nullable|in:Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec',
            'exam_name' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);

        $exists = FeeStructure::where('class_id', $request->class_id)
            ->where('academic_year_id', $request->academic_year_id)
            ->where('fee_type', $request->fee_type)
            ->where('month', $request->month)
            ->where('id', '!=', $feeStructure->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withInput()->withErrors([
                'duplicate' => 'A fee structure for this Class, Year, Type, and Month already exists.'
            ]);
        }

        $feeStructure->update([
            'class_id' => $request->class_id,
            'academic_year_id' => $request->academic_year_id,
            'fee_type' => $request->fee_type,
            'month' => $request->month,
            'exam_name' => $request->exam_name,
            'description' => $request->description,
            'amount' => $request->amount,
            'due_date' => $request->due_date,
        ]);

        // Update all assigned student fees with new amount
        StudentFee::where('fee_structure_id', $feeStructure->id)
                  ->update([
                      'amount' => $feeStructure->amount,
                      'due_date' => $feeStructure->due_date,
                  ]);

        return redirect()->route('fee_structures.index')
                         ->with('success', 'Fee structure updated successfully.');
    }

    public function destroy(FeeStructure $feeStructure)
    {
        // Delete all student fees first
        StudentFee::where('fee_structure_id', $feeStructure->id)->delete();

        $feeStructure->delete();

        return redirect()->route('fee_structures.index')
                         ->with('success', 'Fee structure deleted successfully.');
    }
}

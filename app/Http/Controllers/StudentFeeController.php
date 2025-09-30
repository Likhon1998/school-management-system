<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\FeeStructure;
use App\Models\StudentFee;
use App\Models\FeePayment;
use Illuminate\Http\Request;

class StudentFeeController extends Controller
{
    // Show all fees for students (dashboard)
    public function index()
    {
        $studentFees = StudentFee::with(['student', 'feeStructure', 'payments'])->get();
        return view('student_fees.index', compact('studentFees'));
    }

    // Show create form to assign fee
    public function create()
    {
        $students = Student::all();
        $feeStructures = FeeStructure::all();
        return view('student_fees.create', compact('students', 'feeStructures'));
    }

    // Store assigned fee for student
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'fee_structure_id' => 'required|exists:fee_structures,id',
            'amount_due' => 'required|numeric',
            'remarks' => 'nullable|string|max:255',
        ]);

        StudentFee::create($request->all());

        return redirect()->route('student_fees.index')
                         ->with('success', 'Fee assigned to student successfully.');
    }

    // Show specific student fee details and payments
    public function show(StudentFee $studentFee)
    {
        $studentFee->load(['student', 'feeStructure', 'payments']);
        return view('student_fees.show', compact('studentFee'));
    }

    // Show edit form
    public function edit(StudentFee $studentFee)
    {
        $students = Student::all();
        $feeStructures = FeeStructure::all();
        return view('student_fees.edit', compact('studentFee', 'students', 'feeStructures'));
    }

    // Update assigned fee
    public function update(Request $request, StudentFee $studentFee)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'fee_structure_id' => 'required|exists:fee_structures,id',
            'amount_due' => 'required|numeric',
            'remarks' => 'nullable|string|max:255',
        ]);

        $studentFee->update($request->all());

        return redirect()->route('student_fees.index')
                         ->with('success', 'Student fee updated successfully.');
    }

    // Delete assigned fee
    public function destroy(StudentFee $studentFee)
    {
        $studentFee->delete();
        return redirect()->route('student_fees.index')
                         ->with('success', 'Student fee deleted successfully.');
    }

    // Make payment for a student fee
    public function pay(Request $request, StudentFee $studentFee)
    {
        $request->validate([
            'amount_paid' => 'required|numeric',
            'payment_method' => 'required|in:cash,bank,mobile_banking',
            'payment_date' => 'required|date',
            'receipt_number' => 'required|unique:fee_payments,receipt_number',
        ]);

        $feePayment = $studentFee->payments()->create([
            'amount_paid' => $request->amount_paid,
            'payment_date' => $request->payment_date,
            'payment_method' => $request->payment_method,
            'receipt_number' => $request->receipt_number,
            'status' => $request->amount_paid >= $studentFee->amount_due ? 'paid' : 'partial',
        ]);

        // Update student fee status
        $studentFee->amount_paid += $request->amount_paid;
        $studentFee->status = $studentFee->amount_paid >= $studentFee->amount_due ? 'paid' : 'partial';
        $studentFee->save();

        return redirect()->route('student_fees.show', $studentFee->id)
                         ->with('success', 'Payment added successfully.');
    }
}

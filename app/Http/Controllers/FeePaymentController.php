<?php

namespace App\Http\Controllers;

use App\Models\FeePayment;
use App\Models\Student;
use App\Models\FeeStructure;
use Illuminate\Http\Request;

class FeePaymentController extends Controller
{
    // Display all fee payments
    public function index()
    {
        $feePayments = FeePayment::with(['student', 'feeStructure'])->get();
        return view('fee_payments.index', compact('feePayments'));
    }

    // Show create form
    public function create()
    {
        $students = Student::all();
        $feeStructures = FeeStructure::all();
        return view('fee_payments.create', compact('students', 'feeStructures'));
    }

    // Store multiple payments
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'fee_structure_ids' => 'required|array',
            'fee_structure_ids.*' => 'required|exists:fee_structures,id',
            'amount_paids.*' => 'required|numeric',
            'payment_date_global' => 'required|date',
            'payment_method_global' => 'required|in:cash,bank,mobile_banking',
            'descriptions.*' => 'nullable|string|max:255',
        ]);

        $studentId = $request->student_id;

        foreach ($request->fee_structure_ids as $index => $feeStructureId) {
            $feeStructure = FeeStructure::findOrFail($feeStructureId);

            // Calculate previous payments
            $previousPaid = FeePayment::where('student_id', $studentId)
                                      ->where('fee_structure_id', $feeStructureId)
                                      ->sum('amount_paid');

            $totalPaid = $previousPaid + $request->amount_paids[$index];

            // Determine status
            $status = 'pending';
            if ($totalPaid >= $feeStructure->amount) $status = 'paid';
            elseif ($totalPaid > 0) $status = 'partial';

            FeePayment::create([
                'student_id' => $studentId,
                'fee_structure_id' => $feeStructureId,
                'amount_paid' => $request->amount_paids[$index],
                'payment_date' => $request->payment_date_global,
                'payment_method' => $request->payment_method_global,
                'status' => $status,
                'remarks' => $request->descriptions[$index] ?? null,
                'receipt_number' => 'R-' . $studentId . '-' . $feeStructureId . '-' . time(),
            ]);
        }

        return redirect()->route('fee_payments.index')
                         ->with('success', 'Fee payments added successfully.');
    }

    // Show edit form for a student's multiple payments
    public function editMultiple(Student $student)
    {
        $feeStructures = FeeStructure::all();

        // Calculate paid and due dynamically
        $studentPayments = $feeStructures->map(function($feeStructure) use ($student) {
            $paid = FeePayment::where('student_id', $student->id)
                              ->where('fee_structure_id', $feeStructure->id)
                              ->sum('amount_paid');
            $due = $feeStructure->amount - $paid;
            $status = 'pending';
            if ($paid >= $feeStructure->amount) $status = 'paid';
            elseif ($paid > 0) $status = 'partial';

            $paymentRecord = $student->feePayments()->where('fee_structure_id', $feeStructure->id)->first();

            return [
                'fee_structure' => $feeStructure,
                'paid' => $paid,
                'due' => $due,
                'status' => $status,
                'payment_record' => $paymentRecord,
            ];
        });

        return view('fee_payments.edit', compact('student', 'studentPayments', 'feeStructures'));
    }

    // Update multiple payments for a student
    public function updateMultiple(Request $request, Student $student)
    {
        $request->validate([
            'fee_structure_ids.*' => 'required|exists:fee_structures,id',
            'amount_paids.*' => 'required|numeric',
            'payment_date_global' => 'required|date',
            'payment_method_global' => 'required|in:cash,bank,mobile_banking',
            'descriptions.*' => 'nullable|string|max:255',
        ]);

        foreach($request->fee_structure_ids as $index => $fee_structure_id) {
            $feeStructure = FeeStructure::findOrFail($fee_structure_id);

            // Sum previous payments
            $previousPaid = FeePayment::where('student_id', $student->id)
                                      ->where('fee_structure_id', $fee_structure_id)
                                      ->sum('amount_paid');

            $totalPaid = $previousPaid + $request->amount_paids[$index];

            // Determine status
            $status = 'pending';
            if ($totalPaid >= $feeStructure->amount) $status = 'paid';
            elseif ($totalPaid > 0) $status = 'partial';

            $payment = $student->feePayments()->where('fee_structure_id', $fee_structure_id)->first();

            $data = [
                'amount_paid' => $request->amount_paids[$index],
                'payment_date' => $request->payment_date_global,
                'payment_method' => $request->payment_method_global,
                'status' => $status,
                'remarks' => $request->descriptions[$index] ?? null,
            ];

            if($payment) {
                $payment->update($data);
            } else {
                $data['fee_structure_id'] = $fee_structure_id;
                $data['student_id'] = $student->id;
                $data['receipt_number'] = 'R-' . $student->id . '-' . $fee_structure_id . '-' . time();
                FeePayment::create($data);
            }
        }

        return redirect()->route('fee_payments.editMultiple', ['student' => $student->id])
                         ->with('success', 'Payments updated successfully.');
    }

    // Redirect old edit to editMultiple
    public function edit(FeePayment $feePayment)
    {
        return redirect()->route('fee_payments.editMultiple', ['student' => $feePayment->student_id]);
    }

    // Delete single payment
    public function destroy(FeePayment $feePayment)
    {
        $feePayment->delete();
        return redirect()->route('fee_payments.index')
                         ->with('success', 'Fee payment deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\FeePayment;
use App\Models\Student;
use App\Models\FeeStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeePaymentController extends Controller
{
    // Display all fee payments
    public function index()
{
    // Get all fee payments with related student & fee structure
    $feePayments = FeePayment::with(['student', 'feeStructure'])
        ->get()
        ->groupBy(fn($item) => $item->student_id.'-'.$item->fee_structure_id);

    return view('fee_payments.index', compact('feePayments'));
}


    // Show create form
    public function create()
    {
        $students = Student::all();
        return view('fee_payments.create', compact('students'));
    }

    // Store total payment (partial or full across all dues)
    public function storeTotal(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount_paid' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank,mobile_banking',
            'remarks' => 'nullable|string|max:255',
        ]);

        $student = Student::findOrFail($request->student_id);
        $feeStructures = FeeStructure::all();
        $remainingAmount = $request->amount_paid;

        foreach ($feeStructures as $fee) {
            $paid = FeePayment::where('student_id', $student->id)
                ->where('fee_structure_id', $fee->id)
                ->sum('amount_paid');

            $due = max($fee->amount - $paid, 0);

            if ($due <= 0 || $remainingAmount <= 0) continue;

            $payNow = min($due, $remainingAmount);
            $remainingAmount -= $payNow;

            FeePayment::create([
                'student_id' => $student->id,
                'fee_structure_id' => $fee->id,
                'amount_paid' => $payNow,
                'due_amount' => $due - $payNow,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'status' => $payNow == $due ? 'paid' : 'partial',
                'remarks' => $request->remarks,
                'receipt_number' => 'R-' . $student->id . '-' . $fee->id . '-' . time(),
            ]);

            if ($remainingAmount <= 0) break;
        }

        return redirect()->route('fee_payments.index')->with('success', 'Payment added successfully.');
    }

    // Fetch total dues for a student (AJAX)
    public function getStudentTotalDues(Student $student)
    {
        $feeStructures = FeeStructure::all();

        $totalDue = $feeStructures->reduce(function ($carry, $fee) use ($student) {
            $paid = FeePayment::where('student_id', $student->id)
                ->where('fee_structure_id', $fee->id)
                ->sum('amount_paid');

            $due = max($fee->amount - $paid, 0);
            return $carry + $due;
        }, 0);

        return response()->json(['total_due' => $totalDue]);
    }

    // Existing CRUD (if needed)
    public function editMultiple(Student $student)
    {
        $feeStructures = FeeStructure::all();

        $studentPayments = $feeStructures->map(function ($feeStructure) use ($student) {
            $paid = FeePayment::where('student_id', $student->id)
                ->where('fee_structure_id', $feeStructure->id)
                ->sum('amount_paid');

            $due = max($feeStructure->amount - $paid, 0);
            $status = $this->calculateStatus($feeStructure->amount, $paid);

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

    public function updateMultiple(Request $request, Student $student)
    {
        $request->validate([
            'fee_structure_ids.*' => 'required|exists:fee_structures,id',
            'amount_paids.*' => 'required|numeric|min:0',
            'payment_date_global' => 'required|date',
            'payment_method_global' => 'required|in:cash,bank,mobile_banking',
            'descriptions.*' => 'nullable|string|max:255',
            'receipt_files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        foreach ($request->fee_structure_ids as $index => $feeStructureId) {
            $feeStructure = FeeStructure::findOrFail($feeStructureId);

            $previousPaid = FeePayment::where('student_id', $student->id)
                ->where('fee_structure_id', $feeStructureId)
                ->sum('amount_paid');

            $amountPaid = $request->amount_paids[$index];
            $totalPaid = $previousPaid + $amountPaid;
            $status = $this->calculateStatus($feeStructure->amount, $totalPaid);

            $payment = $student->feePayments()->where('fee_structure_id', $feeStructureId)->first();

            $receiptPath = $payment?->receipt_file;
            if ($request->hasFile("receipt_files.$index")) {
                if ($payment?->receipt_file) {
                    Storage::disk('public')->delete($payment->receipt_file);
                }
                $receiptPath = $request->file("receipt_files.$index")->store('fee_payments/receipts', 'public');
            }

            $data = [
                'amount_paid' => $amountPaid,
                'due_amount' => max($feeStructure->amount - $totalPaid, 0),
                'payment_date' => $request->payment_date_global,
                'payment_method' => $request->payment_method_global,
                'status' => $status,
                'remarks' => $request->descriptions[$index] ?? null,
                'receipt_file' => $receiptPath,
            ];

            if ($payment) {
                $payment->update($data);
            } else {
                $data['student_id'] = $student->id;
                $data['fee_structure_id'] = $feeStructureId;
                $data['receipt_number'] = 'R-' . $student->id . '-' . $feeStructureId . '-' . time();
                FeePayment::create($data);
            }
        }

        return redirect()->route('fee_payments.editMultiple', $student->id)
            ->with('success', 'Payments updated successfully.');
    }

    public function destroy(FeePayment $feePayment)
    {
        if ($feePayment->receipt_file) {
            Storage::disk('public')->delete($feePayment->receipt_file);
        }

        $feePayment->delete();
        return redirect()->route('fee_payments.index')
            ->with('success', 'Fee payment deleted successfully.');
    }

    // Helper function to calculate status
    private function calculateStatus($totalAmount, $paidAmount)
    {
        if ($paidAmount >= $totalAmount) return 'paid';
        if ($paidAmount > 0) return 'partial';
        return 'pending';
    }
}

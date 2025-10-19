<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentFee;
use App\Models\FeePayment;
use App\Models\Student;
use App\Models\FeeStructure;

class StudentFeeController extends Controller
{
    /**
     * Dashboard: show all fees for logged-in student
     */
    public function studentDashboard()
    {
        $student = $this->getLoggedInStudent();

        $studentFees = StudentFee::with('feeStructure')
            ->where('student_id', $student->id)
            ->paginate(10);

        $studentFees->getCollection()->transform(function ($fee) {
            $paid = FeePayment::where('student_id', $fee->student_id)
                ->where('fee_structure_id', $fee->fee_structure_id)
                ->sum('amount_paid');
            $fee->paid_amount = $paid;
            $fee->due_amount = max($fee->amount - $paid, 0);
            return $fee;
        });

        $totalAmount = $studentFees->getCollection()->sum('amount');
        $totalPaid   = $studentFees->getCollection()->sum('paid_amount');
        $totalDue    = $studentFees->getCollection()->sum('due_amount');

        return view('student_fees.dashboard_fees', compact('studentFees', 'totalAmount', 'totalPaid', 'totalDue'));
    }

    /**
     * Show pending dues only (student)
     */
    public function index()
    {
        $student = $this->getLoggedInStudent();

        $studentFees = StudentFee::with('feeStructure')
            ->where('student_id', $student->id)
            ->whereRaw('amount > COALESCE((SELECT SUM(amount_paid) FROM fee_payments WHERE fee_payments.student_id = student_fees.student_id AND fee_payments.fee_structure_id = student_fees.fee_structure_id), 0)')
            ->paginate(10);

        $studentFees->getCollection()->transform(function ($fee) {
            $paid = FeePayment::where('student_id', $fee->student_id)
                ->where('fee_structure_id', $fee->fee_structure_id)
                ->sum('amount_paid');
            $fee->paid_amount = $paid;
            $fee->due_amount = max($fee->amount - $paid, 0);
            return $fee;
        });

        $totalAmount = $studentFees->getCollection()->sum('amount');
        $totalPaid   = $studentFees->getCollection()->sum('paid_amount');
        $totalDue    = $studentFees->getCollection()->sum('due_amount');

        return view('student_fees.index', compact('studentFees', 'totalAmount', 'totalPaid', 'totalDue'));
    }

    /**
     * Show fully paid payments history (student)
     */
    public function history()
    {
        $student = $this->getLoggedInStudent();

        $payments = FeePayment::with(['feeStructure'])
            ->where('student_id', $student->id)
            ->orderBy('payment_date', 'desc')
            ->paginate(10);

        return view('student_fees.history', compact('payments'));
    }

    /**
     * Show single fee details (student)
     */
    public function show(StudentFee $studentFee)
    {
        $student = $this->getLoggedInStudent();

        if ($studentFee->student_id !== $student->id) {
            abort(403, 'Unauthorized');
        }

        $studentFee->load(['feeStructure', 'payments']);
        $studentFee->paid_amount = $studentFee->payments()->sum('amount_paid');
        $studentFee->due_amount = max($studentFee->amount - $studentFee->paid_amount, 0);

        return view('student_fees.show', compact('studentFee'));
    }

    /**
     * Record a payment (admin only)
     */
    public function updatePayment(Request $request, StudentFee $studentFee)
    {
        $user = auth()->user();
        if ($user->role !== 'superadmin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'amount_paid' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string|max:50',
            'remarks' => 'nullable|string|max:255',
        ]);

        $currentPaid = FeePayment::where('student_id', $studentFee->student_id)
            ->where('fee_structure_id', $studentFee->fee_structure_id)
            ->sum('amount_paid');

        $maxPayable = max($studentFee->amount - $currentPaid, 0);
        $payAmount = min($request->amount_paid, $maxPayable);

        if ($payAmount > 0) {
            FeePayment::create([
                'student_id' => $studentFee->student_id,
                'fee_structure_id' => $studentFee->fee_structure_id,
                'amount_paid' => $payAmount,
                'payment_date' => now(),
                'payment_method' => $request->payment_method ?? 'Cash',
                'remarks' => $request->remarks,
            ]);
        }

        return redirect()->back()->with('success', 'Payment recorded successfully.');
    }

    /**
     * Delete a student fee record (admin only)
     */
    public function destroy(StudentFee $studentFee)
    {
        $user = auth()->user();
        if ($user->role !== 'superadmin') {
            abort(403, 'Unauthorized');
        }

        $studentFee->delete();

        return redirect()->back()->with('success', 'Student fee deleted successfully.');
    }

    /**
     * Helper: get logged-in student
     */
    private function getLoggedInStudent()
    {
        $user = auth()->user();
        if ($user->role !== 'student') {
            abort(403, 'Unauthorized');
        }

        $student = Student::where('user_id', $user->id)->first();
        if (!$student) {
            abort(403, 'Unauthorized: No student record found');
        }

        return $student;
    }
}

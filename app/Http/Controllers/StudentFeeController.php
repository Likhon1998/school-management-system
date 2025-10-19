<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentFee;
use App\Models\FeePayment;

class StudentFeeController extends Controller
{
    /**
     * Display a listing of student fees with actual dues.
     */
    public function index(Request $request)
{
    $user = auth()->user();

    $query = StudentFee::with(['student', 'student.class', 'feeStructure']);

    if ($user->role === 'superadmin') {
        if ($request->filled('class_id')) {
            $query->whereHas('student', fn($q) => $q->where('class_id', $request->class_id));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    } elseif ($user->role === 'student') {
        $query->whereHas('student', fn($q) => $q->where('user_id', $user->id));
    } else {
        abort(403, 'Unauthorized access');
    }

    // Use paginate instead of get
    $studentFees = $query->orderBy('due_date', 'asc')->paginate(20);

    // Transform the items in the paginator
    $studentFees->getCollection()->transform(function($fee) {
        $paid = FeePayment::where('student_id', $fee->student_id)
                          ->where('fee_structure_id', $fee->fee_structure_id)
                          ->sum('amount_paid');
        $fee->paid_amount = $paid;
        $fee->due_amount = max($fee->amount - $paid, 0);
        return $fee;
    });

    $totalAmount = $studentFees->getCollection()->sum('amount');
    $totalPaid = $studentFees->getCollection()->sum('paid_amount');
    $totalDue = $studentFees->getCollection()->sum('due_amount');

    return view('student_fees.index', compact('studentFees', 'totalAmount', 'totalPaid', 'totalDue'));
}


    /**
     * Show a specific student fee (details + payment history)
     */
    public function show(StudentFee $studentFee)
    {
        $user = auth()->user();
        $isSuperadmin = $user->role === 'superadmin';
        $isOwner = $studentFee->student && $studentFee->student->user_id === $user->id;

        if ($isSuperadmin || $isOwner) {
            $studentFee->load(['student', 'student.class', 'feeStructure', 'payments']);
            return view('student_fees.show', compact('studentFee'));
        }

        abort(403, 'Unauthorized access');
    }

    /**
     * Update a student fee payment (partial/full). Superadmin only.
     */
    public function updatePayment(Request $request, StudentFee $studentFee)
    {
        $user = auth()->user();
        if ($user->role !== 'superadmin') {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'amount_paid' => 'required|numeric|min:0',
        ]);

        // Add payment and prevent overpayment
        $studentFee->amount_paid += $request->amount_paid;
        if ($studentFee->amount_paid > $studentFee->amount) {
            $studentFee->amount_paid = $studentFee->amount;
        }

        // Update status automatically using model method
        $studentFee->updateStatus();

        return redirect()->back()->with('success', 'Payment updated successfully.');
    }

    /**
     * Delete a student fee (superadmin only)
     */
    public function destroy(StudentFee $studentFee)
    {
        $user = auth()->user();
        if ($user->role !== 'superadmin') {
            abort(403, 'Unauthorized access');
        }

        $studentFee->delete();
        return redirect()->back()->with('success', 'Student fee deleted successfully.');
    }

    /**
     * Student dashboard: show own fees (paginated)
     */
    public function studentDashboard()
    {
        $user = auth()->user();
        if ($user->role !== 'student') {
            abort(403, 'Unauthorized access');
        }

        $studentFees = StudentFee::with(['feeStructure', 'student', 'student.class'])
            ->whereHas('student', fn($q) => $q->where('user_id', $user->id))
            ->orderBy('due_date', 'asc')
            ->paginate(10);

        $studentFees->getCollection()->transform(function($fee) {
            $paid = FeePayment::where('student_id', $fee->student_id)
                              ->where('fee_structure_id', $fee->fee_structure_id)
                              ->sum('amount_paid');
            $fee->paid_amount = $paid;
            $fee->due_amount = max($fee->amount - $paid, 0);
            return $fee;
        });

        $totalDue = $studentFees->getCollection()->sum('due_amount');

        return view('student_fees.dashboard_fees', compact('studentFees', 'totalDue'));
    }
}

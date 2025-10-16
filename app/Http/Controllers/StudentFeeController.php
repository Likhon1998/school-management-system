<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentFee;

class StudentFeeController extends Controller
{
    /**
     * Display a listing of student fees.
     * Superadmin sees all, student sees only own fees, others forbidden.
     * Calculates total dues.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = StudentFee::with(['student', 'feeStructure'])
            ->whereNotNull('fee_structure_id'); // Only fees created via fee structure

        if ($user->role === 'superadmin') {
            // Optional filters
            if ($request->filled('class_id')) {
                $query->whereHas('student', function ($q) use ($request) {
                    $q->where('class_id', $request->class_id);
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
        } elseif ($user->role === 'student') {
            // Show only logged-in student's fees
            $query->where('student_id', $user->id);
        } else {
            abort(403, 'Unauthorized access');
        }

        // Fetch paginated fees
        $studentFees = $query->orderBy('due_date', 'asc')->paginate(20);

        // Calculate total dues for the displayed fees
        $totalDue = $query->sum(\DB::raw('amount - amount_paid'));

        return view('student_fees.index', compact('studentFees', 'totalDue'));
    }

    /**
     * Show a specific student fee (details + payment history).
     */
    public function show(StudentFee $studentFee)
    {
        $user = auth()->user();

        if ($user->role === 'superadmin' || ($user->role === 'student' && $studentFee->student_id === $user->id)) {
            $studentFee->load(['student', 'feeStructure', 'payments']);
            return view('student_fees.show', compact('studentFee'));
        }

        abort(403, 'Unauthorized access');
    }

    /**
     * Update a student fee payment (partial/full).
     * Only superadmin can update payments.
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

        // Add payment amount
        $studentFee->amount_paid += $request->amount_paid;

        // Update status
        if ($studentFee->amount_paid >= $studentFee->amount) {
            $studentFee->status = 'paid';
            $studentFee->amount_paid = $studentFee->amount; // Prevent overpayment
        } elseif ($studentFee->amount_paid > 0) {
            $studentFee->status = 'partial';
        } else {
            $studentFee->status = 'pending';
        }

        $studentFee->save();

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

        $studentFees = StudentFee::with('feeStructure')
                ->where('student_id', $user->id)
                ->orderBy('due_date', 'asc')
                ->paginate(10);

        // Total dues for this student
        $totalDue = StudentFee::where('student_id', $user->id)
                        ->sum(\DB::raw('amount - amount_paid'));

        return view('student_fees.dashboard_fees', compact('studentFees', 'totalDue'));
    }
}

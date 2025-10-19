<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    use HasFactory;

    protected $table = 'fee_payments';

    protected $fillable = [
        'student_id',
        'fee_structure_id',
        'amount_paid',
        'payment_date',
        'payment_method',
        'receipt_number',
        'status',
        'remarks',
        'due_amount',   // new field for remaining due
        'receipt_file', // optional: upload receipt evidence
    ];

    /**
     * Relationships
     */

    // Payment belongs to a Student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Payment belongs to a FeeStructure
    public function feeStructure()
    {
        return $this->belongsTo(FeeStructure::class, 'fee_structure_id');
    }

    /**
     * Boot method to auto-calculate status and due
     */
    protected static function booted()
    {
        static::creating(function ($payment) {
            $totalFee = $payment->feeStructure->amount ?? 0;
            $payment->due_amount = $totalFee - $payment->amount_paid;

            if ($payment->amount_paid == 0) {
                $payment->status = 'pending';
            } elseif ($payment->amount_paid < $totalFee) {
                $payment->status = 'partial';
            } else {
                $payment->status = 'paid';
                $payment->due_amount = 0;
            }
        });

        static::updating(function ($payment) {
            $totalFee = $payment->feeStructure->amount ?? 0;
            $payment->due_amount = $totalFee - $payment->amount_paid;

            if ($payment->amount_paid == 0) {
                $payment->status = 'pending';
            } elseif ($payment->amount_paid < $totalFee) {
                $payment->status = 'partial';
            } else {
                $payment->status = 'paid';
                $payment->due_amount = 0;
            }
        });
    }

    /**
     * Accessor to get remaining due directly
     */
    public function getRemainingDueAttribute()
    {
        $totalFee = $this->feeStructure->amount ?? 0;
        return max($totalFee - $this->amount_paid, 0);
    }
}

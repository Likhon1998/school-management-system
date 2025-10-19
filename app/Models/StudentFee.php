<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFee extends Model
{
    use HasFactory;

    protected $table = 'student_fees';

    protected $fillable = [
        'student_id',
        'fee_structure_id',
        'amount',
        'status',       // pending / partial / paid
        'due_date',
        'remarks',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function feeStructure()
    {
        return $this->belongsTo(FeeStructure::class, 'fee_structure_id');
    }

    // Corrected payments relationship
    public function payments()
    {
        // Only payments for this student and this fee structure
        return $this->hasMany(FeePayment::class, 'student_id', 'student_id')
                    ->where('fee_structure_id', $this->fee_structure_id);
    }

    // Computed attributes
    public function getPaidAmountAttribute()
    {
        // Sum the amount_paid of all related payments
        return $this->payments()->sum('amount_paid');
    }

    public function getDueAmountAttribute()
    {
        return max($this->amount - $this->paid_amount, 0);
    }

    // Update status based on payments
    public function updateStatus()
    {
        $paid = $this->paid_amount;

        if ($paid == 0) {
            $this->status = 'pending';
        } elseif ($paid < $this->amount) {
            $this->status = 'partial';
        } else {
            $this->status = 'paid';
        }

        $this->save();
    }

    // Scope for fully paid fees
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    // Scope for pending or partial fees
    public function scopePending($query)
    {
        return $query->whereIn('status', ['pending', 'partial']);
    }
}

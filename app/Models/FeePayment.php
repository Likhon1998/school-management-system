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
}

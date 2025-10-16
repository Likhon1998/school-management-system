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
        'amount_paid',
        'status',
        'due_date',
        'remarks',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function feeStructure()
    {
        return $this->belongsTo(FeeStructure::class, 'fee_structure_id');
    }

    public function payments()
    {
        return $this->hasMany(FeePayment::class, 'student_fee_id');
    }

    // Update status based on amount_paid
    public function updateStatus()
    {
        if ($this->amount_paid == 0) {
            $this->status = 'pending';
        } elseif ($this->amount_paid < $this->amount) {
            $this->status = 'partial';
        } else {
            $this->status = 'paid';
        }
        $this->save();
    }
}

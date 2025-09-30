<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\StudentFee;

class FeeStructure extends Model
{
    use HasFactory;

    protected $table = 'fee_structures';

    protected $casts = [
        'due_date' => 'date',
    ];

    protected $fillable = [
        'class_id',
        'academic_year_id',
        'fee_type',
        'amount',
        'due_date',
        'month',
        'exam_name',
        'description',
    ];

    /**
     * Boot method to auto-assign fees to students in the class
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($fee) {
            // Get all students in the class
            $students = Student::where('class_id', $fee->class_id)->get();

            foreach ($students as $student) {
                StudentFee::create([
                    'student_id' => $student->id,
                    'fee_structure_id' => $fee->id,
                    'amount' => $fee->amount,
                    'amount_paid' => 0,
                    'status' => 'pending',
                    'due_date' => $fee->due_date,
                ]);
            }
        });
    }

    /**
     * Relationships
     */

    // FeeStructure belongs to a Class
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    // FeeStructure belongs to an Academic Year
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    // FeeStructure has many payments
    public function payments()
    {
        return $this->hasMany(FeePayment::class, 'fee_structure_id');
    }

    // FeeStructure has many student fees
    public function studentFees()
    {
        return $this->hasMany(StudentFee::class, 'fee_structure_id');
    }
}

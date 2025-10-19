<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StudentFee;
use App\Models\FeeStructure;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_id',
        'government_id',
        'student_name',
        'admission_date',
        'admission_number',
        'class_id',
        'section_id',
        'academic_year_id',
        'roll_number',
        'blood_group',
        'religion',
        'nationality',
        'date_of_birth',
        'gender',
        'address',
        'photo',
        'email',
        'parent_email',
        'emergency_contact',
        'medical_info',
        'father_name',
        'father_phone',
        'father_occupation',
        'mother_name',
        'mother_phone',
        'guardian_name',
        'guardian_phone',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        // Generate student_id automatically
        static::creating(function ($student) {
            if (!$student->student_id) {
                $student->student_id = self::generateStudentId($student);
            }
        });

        // Assign fees automatically after student is created
        static::created(function ($student) {
            self::assignFees($student);
        });
    }

    private static function generateStudentId($student)
    {
        $year = date('Y', strtotime($student->admission_date));
        $class = str_pad($student->class_id, 2, '0', STR_PAD_LEFT);

        $lastStudent = self::whereYear('admission_date', $year)
            ->where('class_id', $student->class_id)
            ->latest('id')
            ->first();

        $sequence = $lastStudent ? intval(substr($lastStudent->student_id, -3)) + 1 : 1;
        $sequence = str_pad($sequence, 3, '0', STR_PAD_LEFT);

        return $year . $class . $sequence;
    }

    /**
     * Automatically assign all fee structures of the student's class
     */
    private static function assignFees($student)
    {
        $feeStructures = FeeStructure::where('class_id', $student->class_id)
            ->where('academic_year_id', $student->academic_year_id)
            ->get();

        foreach ($feeStructures as $feeStructure) {
            StudentFee::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'fee_structure_id' => $feeStructure->id,
                ],
                [
                    'amount' => $feeStructure->amount,
                    'status' => 'pending',
                    'due_date' => $feeStructure->due_date,
                ]
            );
        }
    }

    // Relationships
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function academicYear() {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    public function class() {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function section() {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function histories() {
        return $this->hasMany(StudentAcademicHistory::class);
    }

    public function attendances() {
        return $this->hasMany(StudentAttendance::class);
    }

    public function feePayments()
    {
        return $this->hasMany(FeePayment::class);
    }

    public function studentFees()
    {
        return $this->hasMany(StudentFee::class);
    }

    public function totalPaid()
    {
        return $this->feePayments()->sum('amount_paid');
    }

    public function totalDue()
    {
        return $this->studentFees->sum(function ($fee) {
            $paid = $fee->payments()->sum('amount_paid');
            return max($fee->amount - $paid, 0);
        });
    }
}

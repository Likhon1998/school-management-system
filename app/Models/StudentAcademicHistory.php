<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAcademicHistory extends Model
{
    use HasFactory;
    protected $table = 'student_academic_history';

    protected $fillable = [
        'student_name',
        'student_id',
        'academic_year_id',
        'class_id',
        'section_id',
        'roll_number',
        'promotion_status',
    ];

    // Relations
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}

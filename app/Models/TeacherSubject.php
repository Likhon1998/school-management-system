<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'teacher_name', 
        'subject_id',
        'class_id',
        'section_id',
        'academic_year_id',
    ];

    
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id'); 
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }
}

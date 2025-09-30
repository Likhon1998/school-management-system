<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassTeacher extends Model
{
    use HasFactory;

    protected $table = 'class_teachers';

   
    protected $fillable = [
        'teacher_id',
        'teacher_name',
        'class_id',
        'section_id',
        'academic_year_id',
    ];

  
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
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

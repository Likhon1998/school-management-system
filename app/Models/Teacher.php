<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    // Fillable fields
    protected $fillable = [
        'user_id',
        'teacher_name',           // newly added full name
        'employee_id',
        'joining_date',
        'designation',
        'qualification',
        'experience',
        'salary',
        'photo',
        'status',
    ];
    protected $casts = [
    'joining_date' => 'date',
];


    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function teacherSubjects()
    {
        return $this->hasMany(TeacherSubject::class);
    }

   
    public function classTeachers()
    {
        return $this->hasMany(ClassTeacher::class);
    }
}

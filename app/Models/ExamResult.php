<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory;

    protected $table = 'exam_results';

    protected $fillable = [
        'student_id',
        'examination_id',
        'subject_id',
        'obtained_marks',
        'full_marks',
        'grade',
        'gpa',
        'remarks',
    ];

    // Relationship with Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relationship with Examination
    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    // Relationship with Subject
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}

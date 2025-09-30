<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    use HasFactory;

    protected $table = 'student_attendance';

    protected $fillable = [
        'student_id',
        'date',
        'status',
        'remarks',
        'marked_by',
    ];

    // Relationship to Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relationship to Teacher (who marked the attendance)
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'marked_by');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherAttendance extends Model
{
    // Explicitly define the table name
    protected $table = 'teacher_attendance';

    // Fillable fields
    protected $fillable = [
        'teacher_id',
        'date',
        'status',
        'remarks',
        'marked_by',
    ];

    // Relationship to teacher (attendance belongs to a teacher)
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    // Relationship to marker (teacher who marked the attendance)
    public function marker()
    {
        return $this->belongsTo(Teacher::class, 'marked_by');
    }
}

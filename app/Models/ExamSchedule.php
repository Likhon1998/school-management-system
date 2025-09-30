<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'examination_id',
        'subject_id',
        'class_id',
        'exam_date',
        'start_time',
        'end_time',
        'full_marks',
        'pass_marks',
    ];

    // Relationships
    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class); // Assuming your classes table model is ClassModel
    }
}

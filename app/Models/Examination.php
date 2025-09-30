<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    use HasFactory;

    protected $table = 'examinations'; // Explicitly define table name

    protected $fillable = [
        'exam_name',
        'exam_type',
        'academic_year_id',
        'start_date',
        'end_date',
        'status',
    ];

    // Relationships
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    public function schedules()
    {
        return $this->hasMany(ExamSchedule::class, 'examination_id');
    }

    public function results()
    {
        return $this->hasMany(ExamResult::class, 'examination_id');
    }
}

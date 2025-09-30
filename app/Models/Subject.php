<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_name',
        'subject_code',
        'class_id',
        'is_compulsory',
    ];

    // Relationship with Class
    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}

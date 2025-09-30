<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'section_name',
        'capacity',
        'room_number',
        'status' 
    ];

    // Relation to Class
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'class_name',
        'class_numeric',
        'status',
        'class_code'
    ];

    // Relationship with sections
    public function sections()
    {
        return $this->hasMany(Section::class, 'class_id');
    }
}

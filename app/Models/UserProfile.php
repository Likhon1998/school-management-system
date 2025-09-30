<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'address',
        'date_of_birth',
        'gender',
        'photo',
        'national_id',
    ];

    /**
     * Relationship: UserProfile belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

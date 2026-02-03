<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'resume_path',
        'skills',
        'experience',
        'education',
        'profile_photo',
    ];

    // Candidate belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

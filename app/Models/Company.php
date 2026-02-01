<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    // Which fields can be mass assigned
    protected $fillable = [
        'user_id',
        'name',
        'website',
        'address',
    ];

    // Relationship: Company belongs to a recruiter (User)
    public function recruiter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship: Company has many jobs
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',        // the applicant
        'job_id',         // the job applied for
        'status',         // pending, accepted, rejected
        'cover_letter',
        'resume_path',
    ];

    // Link to the job
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    // Link to the user / candidate
    public function user()
    {
        return $this->belongsTo(User::class); // or Candidate if you have a Candidate model
    }
}

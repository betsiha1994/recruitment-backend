<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    // Allow mass assignment
    protected $fillable = ['name'];

    // A category has many jobs
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
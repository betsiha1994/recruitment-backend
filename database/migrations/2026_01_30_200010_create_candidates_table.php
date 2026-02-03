<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidate', function (Blueprint $table) {
            $table->id();
            
            // Link candidate to user
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Candidate-specific fields
            $table->string('resume_path')->nullable();
            $table->text('skills')->nullable();
            $table->text('experience')->nullable();
            $table->text('education')->nullable();
            $table->string('profile_photo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidate');
    }
};

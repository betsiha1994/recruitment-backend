<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('candidate_id')
                  ->constrained('candidates')
                  ->onDelete('cascade');

            $table->foreignId('job_post_id')
                  ->constrained('job_posts')
                  ->onDelete('cascade');

            $table->string('status')->default('pending');
            $table->text('cover_letter')->nullable();
            $table->string('resume_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};

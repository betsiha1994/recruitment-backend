<?php

namespace App\Services;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;

class ApplicationService
{
    /**
     * Submit a new application
     */
    public function createApplication(array $data)
    {
        $user = auth('api')->user();
        if (!$user) {
            abort(401, 'Unauthenticated');
        }

        // Prevent duplicate application
        $existing = Application::where('user_id', $user->id)
            ->where('job_id', $data['job_id'])
            ->first();

        if ($existing) {
            abort(400, 'You have already applied for this job');
        }

        $data['user_id'] = $user->id;

        // Handle resume file safely
        if (isset($data['resume_file']) && $data['resume_file'] && $data['resume_file']->isValid()) {
            $data['resume_path'] = $data['resume_file']->store('resumes', 'public');
            unset($data['resume_file']);
        }

        // Create the application
        return Application::create($data);
    }

    /**
     * Get all applications for a job (Recruiter only)
     */
    public function getApplicationsByJob(Job $job)
    {
        $user = auth('api')->user();

        if (!$user || $job->company_id !== $user->company_id) {
            abort(403, 'Unauthorized');
        }

        return $job->applications()->with('user')->latest()->get();
    }

    /**
     * Update application status (Recruiter only)
     */
    public function updateApplicationStatus(Application $application, string $status)
    {
        $user = auth('api')->user();

        if (!$user || $application->job->company_id !== $user->company_id) {
            abort(403, 'Unauthorized');
        }

        $application->update(['status' => $status]);

        return $application;
    }

    /**
     * Get applications submitted by the current user
     */
    public function getUserApplications()
    {
        $user = auth('api')->user();
        if (!$user) {
            abort(401, 'Unauthenticated');
        }

        return Application::where('user_id', $user->id)->with('job')->latest()->get();
    }
}

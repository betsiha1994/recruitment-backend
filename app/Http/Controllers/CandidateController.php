<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Services\CandidateService;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    protected $candidateService;

    // Constructor without middleware
    public function __construct(CandidateService $candidateService)
    {
        $this->candidateService = $candidateService;
    }

    // Show current user's candidate profile
    public function show()
    {
        $userId = auth()->id();
        $candidate = $this->candidateService->getByUserId($userId);

        if (!$candidate) {
            return response()->json(['message' => 'Candidate profile not found'], 404);
        }

        return response()->json($candidate);
    }

    // Create candidate profile
    public function store(Request $request)
    {
        $request->validate([
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'profile_photo' => 'nullable|image|max:2048',
            'skills' => 'nullable|string',
            'experience' => 'nullable|string',
            'education' => 'nullable|string',
        ]);

        $candidate = $this->candidateService->createCandidate($request->all(), auth()->id());

        return response()->json($candidate, 201);
    }

    // Update candidate profile
    public function update(Request $request, Candidate $candidate)
    {
        if ($candidate->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'profile_photo' => 'nullable|image|max:2048',
            'skills' => 'nullable|string',
            'experience' => 'nullable|string',
            'education' => 'nullable|string',
        ]);

        $candidate = $this->candidateService->updateCandidate($candidate, $request->all());

        return response()->json($candidate);
    }

    // Delete candidate profile
    public function destroy(Candidate $candidate)
    {
        if ($candidate->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $this->candidateService->deleteCandidate($candidate);

        return response()->json(['message' => 'Candidate profile deleted successfully']);
    }
}

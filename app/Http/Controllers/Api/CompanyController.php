<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected CompanyService $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    /**
     * Create a company for the logged-in recruiter
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string',
            'website' => 'nullable|string',
            'address' => 'required|string',
            'logo'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $company = $this->companyService->createCompany($data);

        return response()->json($company, 201);
    }

    /**
     * Get the logged-in recruiter's company
     */
    public function show()
    {
        $company = $this->companyService->getCompany();

        if (!$company) {
            return response()->json(['message' => 'No company found for this recruiter.'], 404);
        }

        return response()->json($company);
    }

    /**
     * Optional: Update the company
     */
    public function update(Request $request)
    {
        $company = $this->companyService->getCompany();

        if (!$company) {
            return response()->json(['message' => 'No company found for this recruiter.'], 404);
        }

        $data = $request->validate([
            'name'    => 'string',
            'website' => 'nullable|string',
            'address' => 'string',
            'logo'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $company = $this->companyService->updateCompany($company, $data);

        return response()->json($company);
    }
}

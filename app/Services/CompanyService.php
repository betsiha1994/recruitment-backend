<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;

class CompanyService
{
    /**
     * Create a new company for the logged-in recruiter
     *
     * @param array $data
     * @return Company
     * @throws \Exception
     */
    public function createCompany(array $data): Company
    {
        $user = Auth::user();

        // Check if recruiter already has a company
        if ($user->company) {
            throw new \Exception("You already have a company assigned.");
        }

        // Handle logo upload if present
        $logoPath = null;
        if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
            $logoPath = $data['logo']->store('logos', 'public'); // storage/app/public/logos
        }

        // Create the company
        $company = Company::create([
            'user_id' => $user->id,
            'name'    => $data['name'],
            'website' => $data['website'] ?? null,
            'address' => $data['address'],
            'logo'    => $logoPath,
        ]);

        return $company;
    }

    /**
     * Get the logged-in recruiter's company
     *
     * @return Company|null
     */
    public function getCompany(): ?Company
    {
        return Auth::user()->company;
    }

    /**
     * Optional: Update a company's details
     */
    public function updateCompany(Company $company, array $data): Company
    {
        // Only allow the logged-in recruiter to update their own company
        if ($company->user_id !== Auth::id()) {
            throw new \Exception("You cannot update this company.");
        }

        // Handle logo upload
        if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
            $data['logo'] = $data['logo']->store('logos', 'public');
        }

        $company->update($data);

        return $company;
    }
}


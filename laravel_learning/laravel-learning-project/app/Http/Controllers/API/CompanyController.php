<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\CompanyRepositoryInterface;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function index()
    {
        $companies = $this->companyRepository->paginate(10);
        return response()->json($companies);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'website' => 'nullable|url',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('company_logos', 'public');
        }

        $company = $this->companyRepository->create($validated);

        return response()->json(['message' => 'Company created successfully', 'company' => $company], 201);
    }

    public function show($id)
    {
        $company = $this->companyRepository->find($id);
        return response()->json($company);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:companies,email,' . $id,
            'website' => 'nullable|url',
        ]);

        $company = $this->companyRepository->update($id, $validated);

        return response()->json(['message' => 'Company updated successfully', 'company' => $company]);
    }

    public function updateLogo(Request $request, $id)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $company = $this->companyRepository->updateLogo($id, $request->file('logo'));

        return response()->json(['message' => 'Logo updated successfully', 'company' => $company]);
    }

    public function destroy($id)
    {
        $this->companyRepository->delete($id);

        return response()->json(['message' => 'Company deleted successfully']);
    }
}

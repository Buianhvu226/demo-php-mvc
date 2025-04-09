<?php

namespace App\Http\Repositories\Eloquent;

use App\Models\Company;
use App\Http\Repositories\Contracts\CompanyRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class CompanyRepository implements CompanyRepositoryInterface
{
    protected $model;

    public function __construct(Company $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function paginate($perPage = 10)
    {
        return $this->model->paginate($perPage);
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $company = $this->find($id);
        $company->update($data);
        return $company->refresh();
    }

    public function delete($id)
    {
        $company = $this->find($id);
        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }
        return $company->delete();
    }

    public function updateLogo($id, $logo)
    {
        $company = $this->find($id);
        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }
        $logoPath = $logo->store('company_logos', 'public');
        $company->logo = $logoPath;
        $company->save();
        return $company->refresh();
    }

    public function getWithEmployees($id)
    {
        return $this->model->with('employees')->findOrFail($id);
    }
}

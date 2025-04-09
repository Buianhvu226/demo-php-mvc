<?php

namespace App\Http\Repositories\Eloquent;

use App\Models\Employee;
use App\Http\Repositories\Contracts\EmployeeRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
    public function __construct(Employee $model)
    {
        parent::__construct($model);
    }

    public function updatePhoto($userId, UploadedFile $photo)
    {
        $employee = $this->find($userId);

        // Delete old photo if exists
        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }

        $photoPath = $photo->store('employee_photos', 'public');
        $employee->photo = $photoPath;
        $employee->save();

        return $employee->refresh();
    }

    public function findByCompany($companyId, $perPage = 10)
    {
        return $this->model->with(['user', 'user.roles'])
            ->where('company_id', $companyId)
            ->paginate($perPage);
    }

    public function getWithUserAndRoles($userId)
    {
        return $this->model->with(['user', 'user.roles'])->findOrFail($userId);
    }

    public function paginate($perPage = 10)
    {
        return $this->model->with(['user', 'user.roles'])->paginate($perPage);
    }

    public function delete($userId)
    {
        $employee = $this->find($userId);

        // Delete photo if exists
        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }

        return $employee->delete();
    }
}

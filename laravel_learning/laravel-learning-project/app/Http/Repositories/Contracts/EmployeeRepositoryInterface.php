<?php

namespace App\Http\Repositories\Contracts;

use Illuminate\Http\UploadedFile;

interface EmployeeRepositoryInterface extends BaseRepositoryInterface
{
    public function updatePhoto($userId, UploadedFile $photo);
    public function findByCompany($companyId, $perPage = 10);
    public function getWithUserAndRoles($userId);
}

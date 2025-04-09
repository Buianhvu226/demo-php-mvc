<?php

namespace App\Http\Repositories\Contracts;

use Illuminate\Http\UploadedFile;

interface CompanyRepositoryInterface extends BaseRepositoryInterface
{
    public function updateLogo($id, UploadedFile $logo);
    public function getWithEmployees($id);
}

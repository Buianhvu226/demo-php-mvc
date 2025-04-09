<?php

namespace App\Http\Repositories\Eloquent;

use App\Models\Role;
use App\Http\Repositories\Contracts\RoleRepositoryInterface;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function findByName($name)
    {
        return $this->model->where('name', $name)->first();
    }

    public function getWithUsers($id)
    {
        return $this->model->with('users')->findOrFail($id);
    }
}

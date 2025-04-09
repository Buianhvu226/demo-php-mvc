<?php

namespace App\Http\Repositories\Contracts;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function findByName($name);
    public function getWithUsers($id);
}

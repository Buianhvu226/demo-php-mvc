<?php

namespace App\Http\Repositories\Contracts;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find user by email
     *
     * @param string $email
     * @return \App\Models\User|null
     */
    public function findByEmail($email);

    /**
     * Get user with roles
     *
     * @param int $id
     * @return \App\Models\User
     */
    public function getWithRoles($id);

    /**
     * Get user with employee data
     *
     * @param int $id
     * @return \App\Models\User
     */
    public function getWithEmployee($id);
}

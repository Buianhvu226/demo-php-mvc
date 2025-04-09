<?php

namespace App\Http\Repositories\Contracts;

interface RoleUserRepositoryInterface
{
    /**
     * Assign role to user
     *
     * @param int $roleId
     * @param int $userId
     * @return bool
     */
    public function assignRole($roleId, $userId);

    /**
     * Update user's role
     *
     * @param int $userId
     * @param int $roleId
     * @return bool
     */
    public function updateRole($userId, $roleId);

    /**
     * Remove role from user
     *
     * @param int $roleId
     * @param int $userId
     * @return bool
     */
    public function removeRole($roleId, $userId);

    /**
     * Check if user has role
     *
     * @param int $userId
     * @return bool
     */
    public function userHasRole($userId);
}

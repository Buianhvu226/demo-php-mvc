<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Contracts\RoleUserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class RoleUserRepository implements RoleUserRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function assignRole($roleId, $userId)
    {
        // Check if user already has a role
        if ($this->userHasRole($userId)) {
            return false;
        }

        return DB::table('role_user')->insert([
            'role_id' => $roleId,
            'user_id' => $userId
        ]);
    }

    /**
     * @inheritDoc
     */
    public function updateRole($userId, $roleId)
    {
        // Remove existing role
        $this->removeUserRoles($userId);

        // Assign new role
        return DB::table('role_user')->insert([
            'role_id' => $roleId,
            'user_id' => $userId
        ]);
    }

    /**
     * @inheritDoc
     */
    public function removeRole($roleId, $userId)
    {
        return DB::table('role_user')
            ->where('role_id', $roleId)
            ->where('user_id', $userId)
            ->delete();
    }

    /**
     * @inheritDoc
     */
    public function userHasRole($userId)
    {
        return DB::table('role_user')->where('user_id', $userId)->exists();
    }

    /**
     * Remove all roles from a user
     *
     * @param int $userId
     * @return bool
     */
    private function removeUserRoles($userId)
    {
        return DB::table('role_user')->where('user_id', $userId)->delete();
    }
}

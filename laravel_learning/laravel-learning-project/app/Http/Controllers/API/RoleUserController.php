<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\RoleUserRepositoryInterface;
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
    protected $roleUserRepository;

    public function __construct(RoleUserRepositoryInterface $roleUserRepository)
    {
        $this->roleUserRepository = $roleUserRepository;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'user_id' => 'required|exists:users,id',
        ]);

        // Check if the user already has a role
        if ($this->roleUserRepository->userHasRole($validated['user_id'])) {
            return response()->json(['message' => 'User already has a role. Use PUT/PATCH to update the role.'], 400);
        }

        // Assign the new role
        $this->roleUserRepository->assignRole($validated['role_id'], $validated['user_id']);

        return response()->json(['message' => 'Role assigned to user successfully']);
    }

    public function update(Request $request, $user_id)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        // Update the user's role
        $this->roleUserRepository->updateRole($user_id, $validated['role_id']);

        return response()->json(['message' => 'Role updated successfully']);
    }

    public function destroy($role_id, $user_id)
    {
        $this->roleUserRepository->removeRole($role_id, $user_id);

        return response()->json(['message' => 'Role removed from user successfully']);
    }
}

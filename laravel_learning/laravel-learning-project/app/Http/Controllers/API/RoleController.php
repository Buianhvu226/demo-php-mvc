<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $roles = $this->roleRepository->all();
        return response()->json($roles);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name|max:255',
        ]);

        $role = $this->roleRepository->create($validated);

        return response()->json(['message' => 'Role created successfully', 'role' => $role], 201);
    }

    public function show($id)
    {
        $role = $this->roleRepository->find($id);
        return response()->json($role);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id . '|max:255',
        ]);

        $role = $this->roleRepository->update($id, $validated);

        return response()->json(['message' => 'Role updated successfully', 'role' => $role]);
    }

    public function destroy($id)
    {
        $this->roleRepository->delete($id);

        return response()->json(['message' => 'Role deleted successfully']);
    }
}

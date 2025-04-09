<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->paginate(10);
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $user = $this->userRepository->create($validated);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    public function show($id)
    {
        $user = $this->userRepository->find($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user = $this->userRepository->update($id, $validated);

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    public function destroy($id)
    {
        $this->userRepository->delete($id);

        return response()->json(['message' => 'User deleted successfully']);
    }
}

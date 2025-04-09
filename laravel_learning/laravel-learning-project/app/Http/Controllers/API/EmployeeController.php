<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\EmployeeRepositoryInterface;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function index()
    {
        $employees = $this->employeeRepository->paginate(10);
        return response()->json($employees);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:employees,user_id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'company_id' => 'required|exists:companies,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('employee_photos', 'public');
        }

        $employee = $this->employeeRepository->create($validated);

        return response()->json(['message' => 'Employee created successfully', 'employee' => $employee], 201);
    }

    public function show($user_id)
    {
        $employee = $this->employeeRepository->getWithUserAndRoles($user_id);
        return response()->json($employee);
    }

    public function showByCompany($company_id)
    {
        $employees = $this->employeeRepository->findByCompany($company_id, 10);
        return response()->json($employees);
    }

    public function update(Request $request, $user_id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'company_id' => 'sometimes|required|exists:companies,id',
        ]);

        $employee = $this->employeeRepository->update($user_id, $validated);

        return response()->json(['message' => 'Employee updated successfully', 'employee' => $employee]);
    }

    public function updatePhoto(Request $request, $user_id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $employee = $this->employeeRepository->updatePhoto($user_id, $request->file('photo'));

        return response()->json(['message' => 'Photo updated successfully', 'employee' => $employee]);
    }

    public function destroy($user_id)
    {
        $this->employeeRepository->delete($user_id);

        return response()->json(['message' => 'Employee deleted successfully']);
    }
}

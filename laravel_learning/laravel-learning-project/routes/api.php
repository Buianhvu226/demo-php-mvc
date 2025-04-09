<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('companies', 'App\Http\Controllers\API\CompanyController');
Route::apiResource('roles', 'App\Http\Controllers\API\RoleController');
Route::apiResource('users', 'App\Http\Controllers\API\UserController');
Route::apiResource('employees', 'App\Http\Controllers\API\EmployeeController');
Route::post('employees/{user_id}/photo', 'App\Http\Controllers\API\EmployeeController@updatePhoto');
Route::post('companies/{company_id}/logo', 'App\Http\Controllers\API\CompanyController@updateLogo');
Route::get('employees/company/{company_id}', 'App\Http\Controllers\API\EmployeeController@showByCompany');
Route::post('roles/{role}/users', 'App\Http\Controllers\API\RoleUserController@store');
Route::put('roles/users/{user}', 'App\Http\Controllers\API\RoleUserController@update');
Route::delete('roles/{role}/users/{user}', 'App\Http\Controllers\API\RoleUserController@destroy');
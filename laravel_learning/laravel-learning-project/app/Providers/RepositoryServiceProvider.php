<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Repositories\Contracts\BaseRepositoryInterface;
use App\Http\Repositories\Eloquent\BaseRepository;
use App\Http\Repositories\Contracts\CompanyRepositoryInterface;
use App\Http\Repositories\Eloquent\CompanyRepository;
use App\Http\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Http\Repositories\Eloquent\EmployeeRepository;
use App\Http\Repositories\Contracts\RoleRepositoryInterface;
use App\Http\Repositories\Eloquent\RoleRepository;
use App\Http\Repositories\Contracts\UserRepositoryInterface;
use App\Http\Repositories\Eloquent\UserRepository;
use App\Http\Repositories\Contracts\RoleUserRepositoryInterface;
use App\Http\Repositories\Eloquent\RoleUserRepository;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleUserRepositoryInterface::class, RoleUserRepository::class);
    }

    public function boot() {}
}

<?php

namespace App\Http\Repositories\Eloquent;

use App\Models\User;
use App\Http\Repositories\Contracts\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * @inheritDoc
     */
    public function getWithRoles($id)
    {
        return $this->model->with('roles')->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function getWithEmployee($id)
    {
        return $this->model->with('employee')->findOrFail($id);
    }
}

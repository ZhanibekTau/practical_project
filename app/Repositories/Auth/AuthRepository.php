<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Repositories\Eloquent\IBaseRepository;
use Illuminate\Database\Eloquent\Model;

class AuthRepository implements IBaseRepository
{
    protected User $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @param array $data
     *
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }


    /**
     * @param string $email
     *
     * @return Model|null
     */
    public function getUserByEmail(string $email): ?Model
    {
        return $this->model->where('email', $email)->first();
    }
}

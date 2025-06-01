<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IProfileRepository;

class ProfileRepository extends BaseRepository implements IProfileRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function getUserById(int $id): ?User
    {
        return $this->model->find($id);
    }

    public function updateUser(int $id, array $data): bool
    {
        return $this->model->find($id)->update($data);
    }

    public function deleteUser(int $id): bool
    {
        return $this->model->find($id)->delete();
    }

    public function updateEmailVerification(int $id): bool
    {
        return $this->model->find($id)->update(['email_verified_at' => null]);
    }
}

<?php

namespace App\Services\Core;

use App\Repositories\Contracts\IUserRepository;
use App\Services\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService extends BaseService
{
    protected IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getPaginatedUsers(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->userRepository->getList($filters, $perPage);
    }

    public function saveUser($user, array $data): bool
    {
        return $this->userRepository->update($user->id, [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role']
        ]);
    }

    public function destroy($id): bool
    {
        return $this->userRepository->update($id, ['status' => 'banned']);
    }

    public function toggleStatus($user): bool
    {
        $newStatus = $user->status === 'active' ? 'inactive' : 'active';

        return $this->userRepository->update($user->id, ['status' => $newStatus]);
    }
}


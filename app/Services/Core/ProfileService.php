<?php

namespace App\Services\Core;

use App\Repositories\Contracts\IProfileRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
    protected $profileRepository;

    /**
     * Create a new class instance.
     */
    public function __construct(IProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function getUserProfile(int $userId)
    {
        return $this->profileRepository->getUserById($userId);
    }

    public function updateProfile(int $userId, array $data)
    {
        $user = $this->profileRepository->getUserById($userId);

        if ($user->isDirty('email')) {
            $this->profileRepository->updateEmailVerification($userId);
        }

        return $this->profileRepository->updateUser($userId, $data);
    }

    public function deleteProfile(int $userId): bool
    {
        return $this->profileRepository->deleteUser($userId);
    }

    public function validatePassword(string $password): bool
    {
        return Hash::check($password, Auth::user()->password);
    }
}

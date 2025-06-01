<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

interface IProfileRepository
{
    public function getUserById(int $id): ?User;
    public function updateUser(int $id, array $data): bool;
    public function deleteUser(int $id): bool;
    public function updateEmailVerification(int $id): bool;
}

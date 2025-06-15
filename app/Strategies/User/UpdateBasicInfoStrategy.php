<?php

namespace App\Strategies\User;

class UpdateBasicInfoStrategy implements UserUpdateStrategy
{
    public function update(array $validatedData, \App\Models\User $user): bool
    {
        // Cập nhật name, email, role
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->role = $validatedData['role'];

        return $user->save();
    }
}
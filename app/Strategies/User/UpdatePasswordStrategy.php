<?php

namespace App\Strategies\User;

use Illuminate\Support\Facades\Hash;

class UpdatePasswordStrategy implements UserUpdateStrategy
{
    public function update(array $validatedData, \App\Models\User $user): bool
    {
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }
        return $user->save();
    }
}
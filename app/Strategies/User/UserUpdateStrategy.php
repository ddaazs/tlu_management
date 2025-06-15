<?php

namespace App\Strategies\User;

interface UserUpdateStrategy
{
    public function update(array $validatedData, \App\Models\User $user): bool;
}

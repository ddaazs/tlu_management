<?php

namespace App\Services;

use App\Strategies\User\UserUpdateStrategy;

class UserUpdateContext
{
    protected UserUpdateStrategy $strategy;

    public function __construct(UserUpdateStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function execute(array $validatedData, \App\Models\User $user): bool
    {
        return $this->strategy->update($validatedData, $user);
    }
}

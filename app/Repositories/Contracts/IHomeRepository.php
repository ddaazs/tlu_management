<?php

namespace App\Repositories\Contracts;

interface IHomeRepository
{
    /**
     * Get home page data
     */
    public function getHomeData(): array;
}

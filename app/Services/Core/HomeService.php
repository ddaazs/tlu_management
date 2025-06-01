<?php

namespace App\Services\Core;

use App\Repositories\Contracts\IHomeRepository;

class HomeService
{
    protected $homeRepository;

    /**
     * Create a new class instance.
     */
    public function __construct(IHomeRepository $homeRepository)
    {
        $this->homeRepository = $homeRepository;
    }

    /**
     * Get home page data
     */
    public function getHomeData(): array
    {
        return $this->homeRepository->getHomeData();
    }
}

<?php

namespace App\Repositories\Eloquent;

use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IHomeRepository;

class HomeRepository extends BaseRepository implements IHomeRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getHomeData(): array
    {
        return [
            'title' => 'Chào mừng đến với Đại học Thủy Lợi',
            'description' => 'Hệ thống quản lý đồ án và thực tập tốt nghiệp'
        ];
    }
}

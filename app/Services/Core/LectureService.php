<?php

namespace App\Services\Core;

use App\Repositories\Eloquent\LectureRepository;

class LectureService
{
    public $lectureRepository;

    /**
     * Create a new class instance.
     */
    public function __construct(LectureRepository $lectureRepository)
    {
        $this->lectureRepository = $lectureRepository;
    }

    public function getLecture()
    {
        return $this->lectureRepository->getAll(['*']);
    }
}

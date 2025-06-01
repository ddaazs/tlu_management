<?php

namespace App\Repositories\Eloquent;

use App\Models\Lecturer;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\ILecturerRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class LectureRepository extends BaseRepository implements ILecturerRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(Lecturer $lecturer)
    {
        parent::__construct($lecturer);
    }

    public function getLecturerByAccountId(int $accountId): ?Lecturer
    {
        return $this->model->where('account_id', $accountId)->first();
    }

    public function getLecturersWithTopics(): LengthAwarePaginator
    {
        return $this->model->with('topics')->paginate(10);
    }
}

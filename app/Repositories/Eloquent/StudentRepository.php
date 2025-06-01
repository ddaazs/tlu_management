<?php

namespace App\Repositories\Eloquent;

use App\Models\Student;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IStudentRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class StudentRepository extends BaseRepository implements IStudentRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(Student $student)
    {
        parent::__construct($student);
    }

    public function getStudentByAccountId(int $accountId): ?Student
    {
        return $this->model->where('account_id', $accountId)->first();
    }

    public function getStudentsWithTopics(): LengthAwarePaginator
    {
        return $this->model->with('topic')->paginate(10);
    }
}

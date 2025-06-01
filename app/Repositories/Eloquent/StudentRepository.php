<?php

namespace App\Repositories\Eloquent;

use App\Models\Student;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IStudentRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class StudentRepository extends BaseRepository implements IStudentRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(Student $student)
    {
        parent::__construct($student);
    }

    public function getAllStudents(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    public function getStudentById(int $id): ?Student
    {
        return $this->model->find($id);
    }

    public function getStudentByAccountId(int $accountId): ?Student
    {
        return $this->model->where('account_id', $accountId)->first();
    }

    public function createStudent(array $data): Student
    {
        return $this->model->create($data);
    }

    public function updateStudent(int $id, array $data): bool
    {
        return $this->model->find($id)->update($data);
    }

    public function deleteStudent(int $id): bool
    {
        return $this->model->find($id)->delete();
    }

    public function getStudent(): Collection
    {
        return $this->model->all();
    }

    public function getStudentsWithTopics(): LengthAwarePaginator
    {
        return $this->model->with('topic')->paginate(10);
    }
}

<?php

namespace App\Repositories\Eloquent;

use App\Models\Internship;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IInternshipRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class InternshipRepository extends BaseRepository implements IInternshipRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(Internship $internship)
    {
        parent::__construct($internship);
    }

    public function getAllInternships(): LengthAwarePaginator
    {
        return $this->model->with(['student', 'company', 'lecturer'])->paginate(10);
    }

    public function getInternshipsByStudentId(int $studentId): LengthAwarePaginator
    {
        return $this->model->with(['student', 'company', 'lecturer'])
            ->where('student_id', $studentId)
            ->paginate(10);
    }

    public function getInternshipById(int $id): ?Internship
    {
        return $this->model->find($id);
    }

    public function createInternship(array $data): Internship
    {
        return $this->model->create($data);
    }

    public function updateInternship(int $id, array $data): bool
    {
        return $this->model->find($id)->update($data);
    }

    public function deleteInternship(int $id): bool
    {
        return $this->model->find($id)->delete();
    }

    public function hasExistingInternship(int $studentId): bool
    {
        return $this->model->where('student_id', $studentId)->exists();
    }
}

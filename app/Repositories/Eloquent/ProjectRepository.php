<?php

namespace App\Repositories\Eloquent;

use App\Models\Project;
use App\Models\Student;
use App\Models\Lecturer;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\IProjectRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository extends BaseRepository implements IProjectRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(Project $project)
    {
        parent::__construct($project);
    }

    public function getAllWithRelations(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->with(['student', 'lecturer']);

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->paginate($perPage);
    }

    public function getStudentProjects(int $studentId, array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->with(['student', 'lecturer'])
            ->where('student_id', $studentId);

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->paginate($perPage);
    }

    public function findWithRelations(int $id): ?Project
    {
        return $this->model->with(['student', 'lecturer'])->find($id);
    }

    public function getStudents(): Collection
    {
        return Student::all();
    }

    public function getLecturers(): Collection
    {
        return Lecturer::all();
    }
}

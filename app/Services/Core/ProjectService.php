<?php

namespace App\Services\Core;

use App\Repositories\Contracts\IProjectRepository;
use App\Repositories\Contracts\IStudentRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProjectService
{
    protected $projectRepository;
    protected $studentRepository;

    /**
     * Create a new class instance.
     */
    public function __construct(
        IProjectRepository $projectRepository,
        IStudentRepository $studentRepository
    ) {
        $this->projectRepository = $projectRepository;
        $this->studentRepository = $studentRepository;
    }

    public function getAllProjects(array $filters = []): LengthAwarePaginator
    {
        return $this->projectRepository->getAllWithRelations($filters);
    }

    public function getStudentProjects(int $studentId, array $filters = []): LengthAwarePaginator
    {
        return $this->projectRepository->getStudentProjects($studentId, $filters);
    }

    public function getProjectById(int $id)
    {
        return $this->projectRepository->findWithRelations($id);
    }

    public function createProject(array $data)
    {
        return $this->projectRepository->create($data);
    }

    public function updateProject(int $id, array $data): bool
    {
        return $this->projectRepository->update($id, $data);
    }

    public function deleteProject(int $id): bool
    {
        return $this->projectRepository->delete($id);
    }

    public function getFormData(): array
    {
        return [
            'students' => $this->projectRepository->getStudents(),
            'lecturers' => $this->projectRepository->getLecturers()
        ];
    }
}

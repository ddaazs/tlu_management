<?php

namespace App\Repositories\Contracts;

use App\Models\Project;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface IProjectRepository
{
    public function getAllWithRelations(array $filters = [], int $perPage = 10): LengthAwarePaginator;
    public function getStudentProjects(int $studentId, array $filters = [], int $perPage = 10): LengthAwarePaginator;
    public function findWithRelations(int $id): ?Project;
    public function create(array $data): Project;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function getStudents(): Collection;
    public function getLecturers(): Collection;
}

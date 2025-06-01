<?php

namespace App\Repositories\Contracts;

use App\Models\Lecturer;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ILecturerRepository
{
    public function getAllLecturers(int $perPage = 8): LengthAwarePaginator;
    public function getLecturerById(int $id): ?Lecturer;
    public function createLecturer(array $data): Lecturer;
    public function updateLecturer(int $id, array $data): bool;
    public function deactivateLecturer(int $id): bool;
    public function getDepartments(): Collection;
    public function getLecture(): Collection;
}

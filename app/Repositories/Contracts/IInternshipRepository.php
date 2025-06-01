<?php

namespace App\Repositories\Contracts;

use App\Models\Internship;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface IInternshipRepository
{
    public function getAllInternships(): LengthAwarePaginator;
    public function getInternshipsByStudentId(int $studentId): LengthAwarePaginator;
    public function getInternshipById(int $id): ?Internship;
    public function createInternship(array $data): Internship;
    public function updateInternship(int $id, array $data): bool;
    public function deleteInternship(int $id): bool;
    public function hasExistingInternship(int $studentId): bool;
}

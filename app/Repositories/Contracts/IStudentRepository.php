<?php

namespace App\Repositories\Contracts;

use App\Models\Student;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface IStudentRepository
{
    public function getAllStudents(int $perPage = 10): LengthAwarePaginator;
    public function getStudentById(int $id): ?Student;
    public function getStudentByAccountId(int $accountId): ?Student;
    public function createStudent(array $data): Student;
    public function updateStudent(int $id, array $data): bool;
    public function deleteStudent(int $id): bool;
    public function getStudent(): Collection;
    public function getStudentsWithTopics(): LengthAwarePaginator;
    public function create(array $data);
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function find(int $id);
    public function getAll(array $columns = ['*']): Collection;
}

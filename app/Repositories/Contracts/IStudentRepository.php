<?php

namespace App\Repositories\Contracts;

use App\Models\Student;
use Illuminate\Pagination\LengthAwarePaginator;

interface IStudentRepository
{
    public function getStudentByAccountId(int $accountId);
    public function getStudentsWithTopics(): LengthAwarePaginator;
    public function create(array $data);
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function find(int $id);
    public function getAll(array $columns = ['*']): \Illuminate\Database\Eloquent\Collection;
}

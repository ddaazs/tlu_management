<?php

namespace App\Repositories\Contracts;

use App\Models\Lecturer;
use Illuminate\Pagination\LengthAwarePaginator;

interface ILecturerRepository
{
    public function getLecturerByAccountId(int $accountId);
    public function getLecturersWithTopics(): LengthAwarePaginator;
    public function create(array $data);
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function find(int $id);
    public function getAll(array $columns = ['*']): \Illuminate\Database\Eloquent\Collection;
}

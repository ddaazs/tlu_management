<?php

namespace App\Repositories\Contracts;

use App\Models\Topic;
use Illuminate\Pagination\LengthAwarePaginator;

interface ITopicRepository
{
    public function getTopicsWithRelations(int $perPage = 10): LengthAwarePaginator;
    public function getTopicsByStatus(string $status): \Illuminate\Database\Eloquent\Collection;
    public function getTopicByStudentId(int $studentId);
    public function getAvailableTopics(): LengthAwarePaginator;
    public function updateStatus(int $id, string $status): bool;
    public function assignStudent(int $topicId, int $studentId): bool;
    public function create(array $data);
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function find(int $id);
    public function getAll(array $columns = ['*']): \Illuminate\Database\Eloquent\Collection;
}

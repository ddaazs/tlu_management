<?php

namespace App\Repositories\Eloquent;

use App\Models\Topic;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\ITopicRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class TopicRepository extends BaseRepository implements ITopicRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(Topic $topic)
    {
        parent::__construct($topic);
    }

    public function getTopicsWithRelations(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->with('lecturer')->paginate($perPage);
    }

    public function getTopicsByStatus(string $status): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->where('status', $status)->get();
    }

    public function getTopicByStudentId(int $studentId): ?Topic
    {
        return $this->model->where('student_id', $studentId)->first();
    }

    public function getAvailableTopics(): LengthAwarePaginator
    {
        return $this->model->with('lecturer')
            ->whereNull('student_id')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function updateStatus(int $id, string $status): bool
    {
        return $this->model->findOrFail($id)->update(['status' => $status]);
    }

    public function assignStudent(int $topicId, int $studentId): bool
    {
        return $this->model->findOrFail($topicId)->update(['student_id' => $studentId]);
    }
}

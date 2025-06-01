<?php

namespace App\Services\Core;

use App\Repositories\Eloquent\TopicRepository;
use App\Services\BaseService;

class TopicService extends BaseService
{
    protected $topicRepository;

    /**
     * Create a new class instance.
     */
    public function __construct(TopicRepository $topicRepository)
    {
        $this->topicRepository = $topicRepository;
    }

    public function getTopics()
    {
        return $this->topicRepository->getTopicsWithRelations();
    }

    public function getPendingTopics()
    {
        return $this->topicRepository->getTopicsByStatus('pending');
    }

    public function getStudentTopic($studentId)
    {
        return $this->topicRepository->getTopicByStudentId($studentId);
    }

    public function getAvailableTopics()
    {
        return $this->topicRepository->getAvailableTopics();
    }

    public function updateTopicStatus($id, $status)
    {
        return $this->topicRepository->updateStatus($id, $status);
    }

    public function assignStudent($topicId, $studentId)
    {
        return $this->topicRepository->assignStudent($topicId, $studentId);
    }

    public function createTopic(array $data)
    {
        return $this->topicRepository->create($data);
    }

    public function updateTopic($id, array $data)
    {
        return $this->topicRepository->update($id, $data);
    }

    public function deleteTopic($id)
    {
        return $this->topicRepository->delete($id);
    }
}

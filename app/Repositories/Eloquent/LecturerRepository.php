<?php

namespace App\Repositories\Eloquent;

use App\Models\Lecturer;
use App\Models\Department;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\ILecturerRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class LecturerRepository extends BaseRepository implements ILecturerRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(Lecturer $lecturer)
    {
        parent::__construct($lecturer);
    }

    public function getLecturerByAccountId(int $accountId): ?Lecturer
    {
        return $this->model->where('account_id', $accountId)->first();
    }

    public function getLecturersWithTopics(): LengthAwarePaginator
    {
        return $this->model->with('topics')->paginate(10);
    }

    public function getAllLecturers(int $perPage = 8): LengthAwarePaginator
    {
        return $this->model->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getLecturerById(int $id): ?Lecturer
    {
        return $this->model->find($id);
    }

    public function createLecturer(array $data): Lecturer
    {
        return $this->model->create($data);
    }

    public function updateLecturer(int $id, array $data): bool
    {
        return $this->model->find($id)->update($data);
    }

    public function deactivateLecturer(int $id): bool
    {
        return $this->model->find($id)->update(['status' => 'Đã nghỉ việc']);
    }

    public function getDepartments(): Collection
    {
        return Department::all();
    }

    public function getLecture(): Collection
    {
        return $this->model->all();
    }
}

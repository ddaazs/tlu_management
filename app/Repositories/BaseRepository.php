<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll(array $columns = ['*']): Collection
    {
        return $this->model->all($columns);
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    public function find(int|string $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int|string $id, array $data): bool
    {
        $item = $this->find($id);
        return $item->update($data);
    }

    public function delete(int|string $id): bool
    {
        $item = $this->find($id);
        return $item->delete();
    }

    public function query(): Builder
    {
        return $this->model->query();
    }

    public function getList(
        array  $filters = [],
        int    $perPage = 15,
        string $sortBy = 'id',
        string $sortOrder = 'desc',
        array  $with = []
    ): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (!empty($with)) {
            $query->with($with);
        }

        foreach ($filters as $field => $value) {
            if (!empty($value)) {
                $query->where($field, $value);
            }
        }

        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }
}

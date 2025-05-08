<?php

namespace App\Services;

use App\Repositories\TaskRepositoryInterface;
use App\Models\Task;

class TaskService
{
    protected $repo;

    public function __construct(TaskRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function listTasks(bool $withTrashed = false)
    {
        $query = Task::query();

        if ($withTrashed) {
            $query->withTrashed();
        }

        return $query->orderBy('created_at','desc')->get();
    }

    public function createTask(array $data)
    {
        return $this->repo->create($data);
    }

    public function updateTask($id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function deleteTask(int $id): void
    {
        // soft delete
        Task::findOrFail($id)->delete();
    }

    public function getTask($id)
    {
        return $this->repo->find($id);
    }

    public function restoreTask(int $id): void
    {
        Task::withTrashed()->findOrFail($id)->restore();
    }

    public function forceDeleteTask(int $id): void
    {
        Task::withTrashed()->findOrFail($id)->forceDelete();
    }
}

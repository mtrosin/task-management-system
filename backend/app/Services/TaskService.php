<?php

namespace App\Services;

use App\Repositories\TaskRepositoryInterface;

class TaskService
{
    protected $repo;

    public function __construct(TaskRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function listTasks()
    {
        return $this->repo->all();
    }

    public function createTask(array $data)
    {
        return $this->repo->create($data);
    }

    public function updateTask($id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function deleteTask($id)
    {
        return $this->repo->delete($id);
    }

    public function getTask($id)
    {
        return $this->repo->find($id);
    }
}

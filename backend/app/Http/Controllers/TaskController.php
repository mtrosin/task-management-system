<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskService;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $service)
    {
        $this->taskService = $service;
    }

    public function index()
    {
        return response()->json($this->taskService->listTasks());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        return response()->json($this->taskService->createTask($data), 201);
    }

    public function show($id)
    {
        return response()->json($this->taskService->getTask($id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'string',
            'description' => 'nullable|string',
            'completed' => 'boolean',
        ]);

        return response()->json($this->taskService->updateTask($id, $data));
    }

    public function destroy($id)
    {
        $this->taskService->deleteTask($id);
        return response()->noContent();
    }
}

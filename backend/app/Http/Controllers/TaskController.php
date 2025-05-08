<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskService;
use Inertia\Inertia;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $service)
    {
        $this->taskService = $service;
    }

    // ✅ Show task list in Inertia/Vue
    public function index()
    {
        $tasks = $this->taskService->listTasks();
        return Inertia::render('Tasks', [
            'tasks' => $tasks
        ]);
    }

    // ✅ Accept form submission from Inertia form
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $this->taskService->createTask($data);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    // ✅ Optional: show a single task in an Inertia page
    public function show($id)
    {
        $task = $this->taskService->getTask($id);
        return Inertia::render('Tasks/Show', [
            'task' => $task
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'string',
            'description' => 'nullable|string',
            'completed' => 'boolean',
        ]);

        $this->taskService->updateTask($id, $data);

        return redirect()->back()->with('success', 'Task updated!');
    }

    public function destroy($id)
    {
        $this->taskService->deleteTask($id);
        return redirect()->back()->with('success', 'Task deleted!');
    }
}

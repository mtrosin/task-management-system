<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Http\Request;
use Inertia\Inertia;

/**
 * @OA\Info(
 *     title="Task Management API",
 *     version="1.0.0",
 *     description="API documentation for your Task Management System"
 * )
 *
 * @OA\Tag(
 *     name="Tasks",
 *     description="Operations related to tasks"
 * )
 */
class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $service)
    {
        $this->taskService = $service;
    }

    /**
     * @OA\Get(
     *     path="/tasks",
     *     operationId="getTasksList",
     *     tags={"Tasks"},
     *     summary="Get list of tasks",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Task")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $tasks = $this->taskService->listTasks();
        return Inertia::render('Tasks', compact('tasks'));
    }

    /**
     * @OA\Post(
     *     path="/tasks",
     *     operationId="storeTask",
     *     tags={"Tasks"},
     *     summary="Create a new task",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             ref="#/components/schemas/TaskInput"
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Task created",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string',
            'description' => 'nullable|string',
        ]);

        $task = $this->taskService->createTask($data);

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully!');
    }

    /**
     * @OA\Get(
     *     path="/tasks/{id}",
     *     operationId="getTaskById",
     *     tags={"Tasks"},
     *     summary="Get a single task",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Task ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(response=404, description="Task not found")
     * )
     */
    public function show($id)
    {
        $task = $this->taskService->getTask($id);

        return Inertia::render('Tasks/Show', compact('task'));
    }

    /**
     * @OA\Patch(
     *     path="/tasks/{id}",
     *     operationId="updateTask",
     *     tags={"Tasks"},
     *     summary="Update an existing task",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Task ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TaskInput")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task updated",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(response=404, description="Task not found")
     * )
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title'       => 'sometimes|string',
            'description' => 'nullable|string',
            'completed'   => 'boolean',
        ]);

        $this->taskService->updateTask($id, $data);

        return redirect()->back()
            ->with('success', 'Task updated successfully!');
    }

    /**
     * @OA\Delete(
     *     path="/tasks/{id}",
     *     operationId="deleteTask",
     *     tags={"Tasks"},
     *     summary="Delete a task",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Task ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Task deleted"),
     *     @OA\Response(response=404, description="Task not found")
     * )
     */
    public function destroy($id)
    {
        $this->taskService->deleteTask($id);

        return redirect()->back()
            ->with('success', 'Task deleted successfully!');
    }

    public function trash()
    {
        $tasks = $this->taskService->listTasks(withTrashed: true)
                                ->whereNotNull('deleted_at');
        return Inertia::render('Trash', compact('tasks'));
    }

    public function restore($id)
    {
        $this->taskService->restoreTask($id);
        return back()->with('success', 'Task restored.');
    }

    public function forceDelete($id)
    {
        $this->taskService->forceDeleteTask($id);
        return back()->with('success', 'Task permanently deleted.');
    }
}

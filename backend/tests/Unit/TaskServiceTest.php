<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\TaskService;
use App\Models\Task;

class TaskServiceTest extends TestCase
{
    use RefreshDatabase;

    private TaskService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(TaskService::class);
    }

    public function test_list_tasks_empty()
    {
        $tasks = $this->service->listTasks();
        $this->assertCount(0, $tasks);
    }

    public function test_create_task()
    {
        $data = ['title' => 'Test Task', 'description' => 'A unit test task'];
        $task = $this->service->createTask($data);

        $this->assertInstanceOf(Task::class, $task);
        $this->assertDatabaseHas('tasks', [
            'id'          => $task->id,
            'title'       => 'Test Task',
            'description' => 'A unit test task',
            'completed'   => false,
        ]);
    }

    public function test_update_task()
    {
        $original = Task::factory()->create([
            'title'       => 'Old Title',
            'description' => 'Old Desc',
            'completed'   => false,
        ]);

        $updated = $this->service->updateTask($original->id, [
            'title'     => 'New Title',
            'completed' => true,
        ]);

        $this->assertEquals('New Title', $updated->title);
        $this->assertTrue($updated->completed);
        $this->assertDatabaseHas('tasks', [
            'id'        => $original->id,
            'title'     => 'New Title',
            'completed' => true,
        ]);
    }

    public function test_delete_task()
    {
        $task = Task::factory()->create();
        $this->service->deleteTask($task->id);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}

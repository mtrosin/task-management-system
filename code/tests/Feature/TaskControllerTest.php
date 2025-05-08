<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Task;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_creates_task_and_redirects()
    {
        $payload = ['title' => 'New Task', 'description' => 'Feature test'];
        
        $response = $this->post('/tasks', $payload);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', $payload + ['completed' => 0]);
    }

    public function test_update_edits_task_and_redirects_back()
    {
        $task = Task::factory()->create(['title' => 'Old']);
        
        $response = $this->patch("/tasks/{$task->id}", [
            'title'     => 'Updated',
            'completed' => true,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', [
            'id'        => $task->id,
            'title'     => 'Updated',
            'completed' => 1,
        ]);
    }

    public function test_destroy_deletes_task()
    {
        $task = Task::factory()->create();

        $response = $this->delete("/tasks/{$task->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}

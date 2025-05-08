<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    // The name of the factory’s corresponding model.
    protected $model = Task::class;

    public function definition()
    {
        return [
            'title'       => $this->faker->sentence(3),
            'description' => $this->faker->optional()->paragraph(),
            'completed'   => $this->faker->boolean(20),
        ];
    }
}

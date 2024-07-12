<?php

namespace Database\Factories;

use App\Models\User;
use App\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle(),
            'description' => fake()->realTextBetween(20, 150),
            // 'status' => fake()->randomElement(TaskStatus::toArray()),
            'status' => TaskStatus::TO_DO,
            'created_by' => User::factory(),
            'deadline' => fake()->dateTimeBetween('now', '+3 months'),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {



        return [
            'title' => fake()->word(),
        ];
    }

    public function silver()
    {
        return $this->state(function (array $attributes) {
            return [
                'title' => 'Silver',
            ];
        });
    }

    public function gold()
    {
        return $this->state(function (array $attributes) {
            return [
                'title' => 'Gold',
            ];
        });
    }
}

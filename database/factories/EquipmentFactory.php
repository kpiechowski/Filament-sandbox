<?php

namespace Database\Factories;

use App\Models\Workshop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment>
 */
class EquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => ucfirst(fake()->words(rand(2,4), true)),
            'brand' => fake()->company(), 
            'model' => fake()->bothify('??##'),
            'quantity' => rand(100,200),
            'description' => fake()->realText(100),
        ];
    }
}

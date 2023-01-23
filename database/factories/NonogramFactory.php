<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nonogram>
 */
class NonogramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->word(),
            'height' => fake()->numberBetween(5, 20),
            'width' => fake()->numberBetween(5, 20),
            'result' => [[0]],
            'task' => ['top' => [[]], 'left' => [[]]],
            'author_id' => User::all()->first()->id
        ];
    }
}

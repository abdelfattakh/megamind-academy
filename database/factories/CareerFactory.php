<?php

namespace Database\Factories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CareerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'position_id' => Position::query()->inRandomOrder()->first()?->id,
            'last_name' => fake()->lastName,
            'first_name' => fake()->firstName,
            'email' => fake()->email,
            'comment' => fake()->text,
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Age>
 */
class AgeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => [
                'ar' => fake('ar_SA')->name(),
                'en' => 'اسم جديد #' . fake()->numberBetween(1, 100000),
            ],
            'description' => [
                'ar' => fake('ar_SA')->name(),
                'en' => 'وصف جديد #' . fake()->numberBetween(1, 100000),
            ],
            'is_active' => $this->faker->boolean(100)
        ];
    }
}

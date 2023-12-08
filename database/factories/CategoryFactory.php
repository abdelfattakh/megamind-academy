<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
                'en' => 'تصنيف جديد #' . fake()->numberBetween(1, 100000),
            ],
            'is_active' => $this->faker->boolean(100)
        ];
    }
}

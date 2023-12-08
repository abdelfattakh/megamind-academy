<?php

namespace Database\Factories;

use App\Models\Age;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AgeCategory>
 */
class AgeCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'age_id' => Age::query()->inRandomOrder()->first()?->id,
            'category_id' => Category::query()->inRandomOrder()->first()?->id,
        ];
    }
}
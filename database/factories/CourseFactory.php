<?php

namespace Database\Factories;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CourseFactory extends Factory
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
            'description' => [
                'ar' => fake('ar_SA')->name(),
                'en' => 'تصنيف جديد #' . fake()->numberBetween(1, 100000),
            ],
            'prerequisites' => [fake()->name, fake()->name, fake()->name],
            'curriculum' => [fake()->name, fake()->name, fake()->name],
            'category_id' => Category::query()->inRandomOrder()->first()?->id,
            'price' => number_format(rand(1, 20), 2, '.', ''),
            'session_no' => rand(1, 12),
            'discount_value' => rand(5, 100),
            'discount_expiration_date' => Carbon::now()->addDays(3),
            'is_active' => $this->faker->boolean(90),
            'is_top_course' => $this->faker->boolean(30),
            'course_location' => ['Online', 'Offline'],
        ];
    }
}

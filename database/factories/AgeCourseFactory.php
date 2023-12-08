<?php

namespace Database\Factories;

use App\Models\Age;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AgeCourse>
 */
class AgeCourseFactory extends Factory
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
            'course_id' => Course::query()->inRandomOrder()->first()?->id,
        ];
    }
}

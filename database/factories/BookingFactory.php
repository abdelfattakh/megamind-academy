<?php

namespace Database\Factories;

use App\Enums\CourseLocationsEnum;
use App\Enums\DaysEnum;
use App\Models\City;
use App\Models\Country;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'full_name' => fake()->firstName,
            'location_of_course' => CourseLocationsEnum::Online,
            'days' => $this->faker->randomElement([DaysEnum::Saturday, DaysEnum::Sunday, DaysEnum::Monday]),
            'phone' => fake()->numerify('010########'),
            'phone_country' => $this->faker->randomElement(['EG']),
            'date_of_birth' => fake()->date,
            'course_id' => Course::query()->inRandomOrder()->first()?->id,
            'country_id' => Country::query()->inRandomOrder()->first()?->id,
            'city_id' => City::query()->inRandomOrder()->first()?->id,
            'user_id' => User::query()->inRandomOrder()->first()?->id,
        ];
    }
}

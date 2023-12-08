<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws FileCannotBeAdded
     */
    public function run(): void
    {
        collect([
            [
                'name' => [
                    'ar' => 'علم الروبوتات',
                    'en' => 'Robotics',
                ],
                'description' => [
                    'ar' => 'تطوير المهارات منذ الصغر أمر ضروري لحياة أفضل',
                    'en' => 'Developing skills from a young age is essential for a better life',
                ],
                'is_active' => true,
                'is_top_course' => true,
                'prerequisites' => [],
                'curriculum' => [],
                'course_location' => collect(['Online', 'Udemy'])->toArray(),
                'category_id' => 1,
                'price' => rand(100, 600),
                'discount_value' => rand(0, 50),
                'discount_expiration_date' => now()->addMonth(),
                'session_no' => rand(4, 10),
                'image' => 'https://aquadic.github.io/megamind_front/images/logo.webp',
            ],
            [
                'name' => [
                    'ar' => 'صناعة الألعاب',
                    'en' => 'Game Development',
                ],
                'description' => [
                    'ar' => 'تطوير المهارات منذ الصغر أمر ضروري لحياة أفضل',
                    'en' => 'Developing skills from a young age is essential for a better life',
                ],
                'is_active' => true,
                'is_top_course' => true,
                'prerequisites' => [],
                'curriculum' => [],
                'course_location' => collect(['Online', 'Udemy'])->toArray(),
                'category_id' => 2,
                'price' => rand(100, 600),
                'discount_value' => rand(0, 50),
                'discount_expiration_date' => now()->addMonth(),
                'session_no' => rand(4, 10),
                'image' => 'https://aquadic.github.io/megamind_front/images/screencapture3.webp',
            ],
            [
                'name' => [
                    'ar' => 'الرسوم المتحركة',
                    'en' => 'Animation',
                ],
                'description' => [
                    'ar' => 'تطوير المهارات منذ الصغر أمر ضروري لحياة أفضل',
                    'en' => 'Developing skills from a young age is essential for a better life',
                ],
                'is_active' => true,
                'is_top_course' => true,
                'prerequisites' => [],
                'curriculum' => [],
                'course_location' => collect(['Online', 'Udemy'])->toArray(),
                'category_id' => 3,
                'price' => rand(100, 600),
                'discount_value' => rand(0, 50),
                'discount_expiration_date' => now()->addMonth(),
                'session_no' => rand(4, 10),
                'image' => 'https://aquadic.github.io/megamind_front/images/screencapture4.webp',
            ],
            [
                'name' => [
                    'ar' => 'تطبيقات الجوال',
                    'en' => 'Mobile Applications',
                ],
                'description' => [
                    'ar' => 'تطوير المهارات منذ الصغر أمر ضروري لحياة أفضل',
                    'en' => 'Developing skills from a young age is essential for a better life',
                ],
                'is_active' => true,
                'is_top_course' => true,
                'prerequisites' => [],
                'curriculum' => [],
                'course_location' => [collect(['Online', 'Udemy'])->random()],
                'category_id' => 2,
                'price' => rand(100, 600),
                'discount_value' => rand(0, 50),
                'discount_expiration_date' => now()->addMonth(),
                'session_no' => rand(4, 10),
                'image' => 'https://aquadic.github.io/megamind_front/images/screencapture2.webp',
            ],
            [
                'name' => [
                    'ar' => 'أساسيات البرمجة',
                    'en' => 'Coding Essentials',
                ],
                'description' => [
                    'ar' => 'تطوير المهارات منذ الصغر أمر ضروري لحياة أفضل',
                    'en' => 'Developing skills from a young age is essential for a better life',
                ],
                'is_active' => true,
                'is_top_course' => true,
                'prerequisites' => [],
                'curriculum' => [],
                'course_location' => [collect(['Online', 'Udemy'])->random()],
                'category_id' => 2,
                'price' => rand(100, 600),
                'discount_value' => rand(0, 50),
                'discount_expiration_date' => now()->addMonth(),
                'session_no' => rand(4, 10),
                'image' => 'https://aquadic.github.io/megamind_front/images/screencapture4.webp',
            ],
            [
                'name' => [
                    'ar' => 'تصميم الرسومات',
                    'en' => 'Graphic Design',
                ],
                'description' => [
                    'ar' => 'تطوير المهارات منذ الصغر أمر ضروري لحياة أفضل',
                    'en' => 'Developing skills from a young age is essential for a better life',
                ],
                'is_active' => true,
                'is_top_course' => true,
                'prerequisites' => [],
                'curriculum' => [],
                'course_location' => collect(['Online', 'Udemy'])->toArray(),
                'category_id' => 3,
                'price' => rand(100, 600),
                'discount_value' => rand(0, 50),
                'discount_expiration_date' => now()->addMonth(),
                'session_no' => rand(4, 10),
                'image' => 'https://aquadic.github.io/megamind_front/images/screencapture2.webp',
            ],
            [
                'name' => [
                    'ar' => 'برمجة المواقع',
                    'en' => 'Web Development',
                ],
                'description' => [
                    'ar' => 'تطوير المهارات منذ الصغر أمر ضروري لحياة أفضل',
                    'en' => 'Developing skills from a young age is essential for a better life',
                ],
                'is_active' => true,
                'is_top_course' => true,
                'prerequisites' => [],
                'curriculum' => [],
                'course_location' => [collect(['Online', 'Udemy'])->random()],
                'category_id' => 2,
                'price' => rand(100, 600),
                'discount_value' => rand(0, 50),
                'discount_expiration_date' => now()->addMonth(),
                'session_no' => rand(4, 10),
                'image' => 'https://aquadic.github.io/megamind_front/images/screencapture4.webp',
            ],
            [
                'name' => [
                    'ar' => 'ويدو ؟؟ ##',
                    'en' => 'Wedo ?? ##',
                ],
                'description' => [
                    'ar' => 'تطوير المهارات منذ الصغر أمر ضروري لحياة أفضل',
                    'en' => 'Developing skills from a young age is essential for a better life',
                ],
                'is_active' => true,
                'is_top_course' => true,
                'prerequisites' => [],
                'curriculum' => [],
                'course_location' => collect(['Online', 'Udemy'])->toArray(),
                'category_id' => 2,
                'price' => rand(100, 600),
                'discount_value' => rand(0, 50),
                'discount_expiration_date' => now()->addMonth(),
                'session_no' => rand(4, 10),
                'image' => 'https://aquadic.github.io/megamind_front/images/screencapture1.webp',
            ],
        ])->each(function ($v) {
            $this->command->info("Adding Course {$v['name']['en']}");
            /** @var Course $course */
            $course = Course::query()->create(Arr::except($v, 'image'));
            $course->ages()->attach(collect([1, 2, 3])->random(2));
            $course->addMediaFromUrl($v['image'])->toMediaCollection((new Course)->getPrimaryMediaCollection());
        });
    }
}

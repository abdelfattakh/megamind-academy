<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            [
                'name' => [
                    'ar' => 'مدرب علم الروبوتات',
                    'en' => 'Instructor Robotics',
                ],
                'is_active' => true,
            ],
            [
                'name' => [
                    'ar' => 'مدرب صناعة الألعاب',
                    'en' => 'Instructor Game Development',
                ],
                'is_active' => true,
            ],
            [
                'name' => [
                    'ar' => 'مدرب الرسوم المتحركة',
                    'en' => 'Instructor Animation',
                ],
                'is_active' => true,
            ],
            [
                'name' => [
                    'ar' => 'مدرب تطبيقات الجوال',
                    'en' => 'Instructor Mobile Applications',
                ],
                'is_active' => true,
            ],
            [
                'name' => [
                    'ar' => 'مدرب أساسيات البرمجة',
                    'en' => 'Instructor Coding Essentials',
                ],
                'is_active' => true,
            ],
            [
                'name' => [
                    'ar' => 'مدرب تصميم الرسومات',
                    'en' => 'Instructor Graphic Design',
                ],
                'is_active' => true,
            ],
            [
                'name' => [
                    'ar' => 'مدرب برمجة المواقع',
                    'en' => 'Instructor Web Development',
                ],
                'is_active' => true,
            ],
            [
                'name' => [
                    'ar' => 'مدرب ويدو ؟؟ ##',
                    'en' => 'Instructor Wedo ?? ##',
                ],
                'is_active' => true,
            ],
        ])->each(function ($v) {
            $this->command->info("Adding Position {$v['name']['en']}");
            Position::query()->create($v);
        });
    }
}

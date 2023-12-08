<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            [
                'name' => [
                    'ar' => 'علم الروبوتات',
                    'en' => 'Robotics',
                ],
                'is_active' => true,
            ],
            [
                'name' => [
                    'ar' => 'البرمجة',
                    'en' => 'Programming',
                ],
                'is_active' => true,
            ],
            [
                'name' => [
                    'ar' => 'تصميم الرسومات',
                    'en' => 'Graphic Design',
                ],
                'is_active' => true,
            ],
        ])->each(function ($v) {
            $this->command->info("Adding Category {$v['name']['en']}");
            Category::query()->create($v);
        });
    }
}

<?php

namespace Database\Seeders;

use App\Models\Age;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;

class AgeSeeder extends Seeder
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
                    'ar' => 'من 6 الي 9',
                    'en' => 'From 6 to 9',
                ],
                'description' => [
                    'ar' => 'تطوير المهارات منذ الصغر أمر ضروري لحياة أفضل',
                    'en' => 'Developing skills from a young age is essential for a better life',
                ],
                'is_active' => true,
                'image' => 'https://aquadic.github.io/megamind_front/images/imgCricle1.webp',
            ],
            [
                'name' => [
                    'ar' => 'من 10 الي 13',
                    'en' => 'From 10 to 13',
                ],
                'description' => [
                    'ar' => 'تطوير المهارات منذ الصغر أمر ضروري لحياة أفضل',
                    'en' => 'Developing skills from a young age is essential for a better life',
                ],
                'is_active' => true,
                'image' => 'https://aquadic.github.io/megamind_front/images/imgCricle2.webp',
            ],
            [
                'name' => [
                    'ar' => 'من 14 الي 19',
                    'en' => 'From 14 to 19',
                ],
                'description' => [
                    'ar' => 'تطوير المهارات منذ الصغر أمر ضروري لحياة أفضل',
                    'en' => 'Developing skills from a young age is essential for a better life',
                ],
                'is_active' => true,
                'image' => 'https://aquadic.github.io/megamind_front/images/imgCricle3.webp',
            ]
        ])->each(function(array $v) {
            $this->command->info("Adding Age {$v['name']['en']}");
            /** @var Age $age */
            $age = Age::query()->create(Arr::except($v, 'image'));
            $age->addMediaFromUrl($v['image'])->toMediaCollection((new Age)->getPrimaryMediaCollection());
        });
    }
}

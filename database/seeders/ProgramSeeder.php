<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws FileCannotBeAdded
     */
    public function run(): void
    {
        collect([
            [
                'name' => 'Python',
                'is_active' => true,
                'image' => 'https://aquadic.github.io/megamind_front/images/used.webp',
            ],
            [
                'name' => 'Android',
                'is_active' => true,
                'image' => 'https://aquadic.github.io/megamind_front/images/android.webp',
            ],
            [
                'name' => 'Visual',
                'is_active' => true,
                'image' => 'https://aquadic.github.io/megamind_front/images/visual.webp',
            ],
            [
                'name' => 'Figma',
                'is_active' => true,
                'image' => 'https://aquadic.github.io/megamind_front/images/figma.webp',
            ],
            [
                'name' => 'Photoshop',
                'is_active' => true,
                'image' => 'https://aquadic.github.io/megamind_front/images/ps.webp',
            ],
            [
                'name' => 'Flutter',
                'is_active' => true,
                'image' => 'https://aquadic.github.io/megamind_front/images/flutter.webp',
            ],
            [
                'name' => 'Java',
                'is_active' => true,
                'image' => 'https://aquadic.github.io/megamind_front/images/java.webp',
            ],
            [
                'name' => 'Unity',
                'is_active' => true,
                'image' => 'https://aquadic.github.io/megamind_front/images/unity.webp',
            ],
        ])->each(function (array $v) {
            $this->command->info("Adding Program {$v['name']}");
            /** @var Program $Program */
            $Program = Program::query()->create(Arr::except($v, 'image'));
            $Program->addMediaFromUrl($v['image'])->toMediaCollection((new Program)->getPrimaryMediaCollection());
        });
    }
}

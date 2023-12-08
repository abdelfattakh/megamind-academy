<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;

class SocialMediaSeeder extends Seeder
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
                    'ar' => 'فيسبوك',
                    'en' => 'Facebook',
                ],
                'link' => 'https://www.facebook.com/MegamindsEgypt',
                'is_active' => true,
                'image' => 'https://aquadic.github.io/megamind_front/images/facebook.webp',
            ],
            [
                'name' => [
                    'ar' => 'انستجرام',
                    'en' => 'Instagram',
                ],
                'link' => 'https://www.instagram.com/megamind.kids/',
                'is_active' => true,
                'image' => 'https://aquadic.github.io/megamind_front/images/instagram.webp',
            ],
            [
                'name' => [
                    'ar' => 'متجر بلاي',
                    'en' => 'Playstore',
                ],
                'link' => 'https://play.google.com/store/apps/dev?id=9088832345397272939',
                'is_active' => true,
                'image' => 'https://cdn-icons-png.flaticon.com/128/300/300218.png',
            ],
        ])->each(function(array $v) {
            $this->command->info("Adding Social Media {$v['name']['en']}");
            /** @var SocialMedia $socialMedia */
            $socialMedia = SocialMedia::query()->create(Arr::except($v, 'image'));
            $socialMedia->addMediaFromUrl($v['image'])->toMediaCollection((new SocialMedia)->getPrimaryMediaCollection());
        });
    }
}

<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws FileCannotBeAdded
     */
    public function run(): void
    {
        collect([
            [
                'name' => fake('ar_SA')->name(),
                'comment' => 'السلام عليكم ورحمة الله وبركاته جزاك الله خيرا م.روان حقيقي شكرا جدا علي الكورس الرائع و فعلا مستوي عبد الرحمن اختلف جدا واتعلم حاجات كتيرة وكان مستمتع جدا طول فترة الكورس و متحمس جدا للكورس القادم ان شاء الله',
                'is_active' => true,
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/ff/Facebook_logo_36x36.svg/2048px-Facebook_logo_36x36.svg.png',
            ],
            [
                'name' => fake('ar_SA')->name(),
                'comment' => 'حبيت اشكركم علي المجهود الرائع اللي بتبذلوه ربنا ينفع بيكم الاولاد مبسوطين جدا و بيستنوا السيشن من الاسبوع للأسبوع بفارغ الصبر كنت فاكره ان وقت ساعتين كتير و هيزهقوا لكن الحمدلله بيكونوا مستمعتين ومش عاوزين الوقت يخلص',
                'is_active' => true,
                'image' => 'https://aquadic.github.io/megamind_front/images/instaslide.webp',
            ],
            [
                'name' => fake('ar_SA')->name(),
                'comment' => 'مفيش كلام يوفي الباشمهندسة اماني ماشاء الله عندها صبر و سعه صدر و استيعاب للاطفال و حرص إن كل الاطفال تفهم و تطبق بالتوفيق دائما يارب',
                'is_active' => true,
                'image' => 'https://png.pngtree.com/png-vector/20221018/ourmid/pngtree-whatsapp-icon-png-image_6315990.png',
            ]
        ])->each(function(array $v) {
            $this->command->info("Adding Review {$v['name']}");
            /** @var Review $review */
            $review = Review::query()->create(Arr::except($v, 'image'));
            $review->addMediaFromUrl($v['image'])->toMediaCollection((new Review)->getPrimaryMediaCollection());
        });
    }
}

<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;

class SubscriptionSeeder extends Seeder
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
                    'ar' => 'سنوي',
                    'en' => 'Yearly',
                ],
                'price' => 600,
                'currency' => ['ar' => 'ج.م', 'en' => 'EGP'],
                'benefits' => ['ar' => [
                    ['desc' => '12 جلسة صوتية',],
                    ['desc' => '12 جلسة صوتية',],
                    ['desc' => '12 جلسة صوتية',],
                ],
                    'en' => [
                        ['desc' => '12 session',],
                        ['desc' => '12 session',],
                        ['desc' => '12 session',],
                    ],
                ],
                'is_active' => true,
            ],
            [
                'name' => [
                    'ar' => 'شهري',
                    'en' => 'Monthly',
                ],
                'price' => 200,
                'currency' => ['ar' => 'ج.م', 'en' => 'EGP'],
                'benefits' => ['ar' => [
                    ['desc' => '6 جلسة صوتية',],
                    ['desc' => '6 جلسة صوتية',],
                    ['desc' => '6 جلسة صوتية',],
                ],
                    'en' => [
                        ['desc' => '6 session',],
                        ['desc' => '6 session',],
                        ['desc' => '6 session',],
                    ],
                ],
                'is_active' => true,
            ],
        ])->each(function ($v) {
            $this->command->info("Adding Payment Method {$v['name']['en']}");
            /** @var Subscription $subscription */
            $subscription = Subscription::query()->create(Arr::except($v, 'image'));
        });
    }
}

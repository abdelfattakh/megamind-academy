<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\PaymentMethod;
use App\Settings\AboutUsSettings;
use App\Settings\ContactUsSettings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;

class PaymentMethodSeeder extends Seeder
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
                    'ar' => 'فودفون كاش',
                    'en' => 'Vodafone Cash',
                ],
                'phone' => (new ContactUsSettings())->whatsapp_phone,

                'is_active' => true,
                'image' => 'https://aquadic.github.io/megamind_front/images/cash.webp',
            ],
            [
                'name' => [
                    'ar' => 'باي موب',
                    'en' => 'Paymob',
                ],
                'link' => "https://aquadic.com",

                'is_active' => true,
                'image' => 'https://aquadic.github.io/megamind_front/images/paymob.webp',
            ],
            [
                'name' => [
                    'ar' => 'باي بال',
                    'en' => 'Paypal',
                ],
                'link' => "https://paypal.me/Saifallak",

                'is_active' => true,
                'image' => 'https://aquadic.github.io/megamind_front/images/paypal.webp',
            ],
        ])->each(function ($v) {
            $this->command->info("Adding Payment Method {$v['name']['en']}");
            /** @var PaymentMethod $paymentMethod */
            $paymentMethod = PaymentMethod::query()->create(Arr::except($v, 'image'));
            $paymentMethod->addMediaFromUrl($v['image'])->toMediaCollection((new PaymentMethod)->getPrimaryMediaCollection());
        });
    }
}

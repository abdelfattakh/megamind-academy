<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ContactUsSettings extends Settings
{



    /**
     * phone.
     * @var string
     */
    public string $first_phone;

    /**
     * phone.
     * @var string
     */
    public ?string $second_phone;
    /**
     * whatsapp_phone.
     * @var string
     */
    public string $whatsapp_phone;

    /**
     * email.
     * @var string
     */
    public string $email;

    /**
     * address.
     * @var string
     */
    public string $address;

    public static function group(): string
    {
        return 'contact_us';
    }

    protected static function defaults(): array
    {
        return [
            'first_name' => 'navigation_horizontal',
            'last_name' => 'navigation_horizontal',
            'email' => 'gehad@gmail.com',
            'first_phone' => 'navigation_horizontal',
            'whatsapp_phone' => 'navigation_horizontal',
        ];
    }
}

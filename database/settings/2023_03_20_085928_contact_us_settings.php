<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('contact_us.second_phone');
        $this->migrator->add('contact_us.first_phone', '+201008161964');
        $this->migrator->add('contact_us.whatsapp_phone', '+201008161964');
        $this->migrator->add('contact_us.email','Contact@Megaminds-Academy.com');
        $this->migrator->add('contact_us.address','Retaj Tower, 7 Buhaira Street, behind, Al Awram Church, Jankles, Alexandria Governorate');
    }
};

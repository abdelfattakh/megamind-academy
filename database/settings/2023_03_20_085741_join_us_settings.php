<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('join_us.name', 'not written yet');
        $this->migrator->add('join_us.description','not written yet');
    }
};

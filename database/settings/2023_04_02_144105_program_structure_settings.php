<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('structure.weekly_hours', '2.5');
        $this->migrator->add('structure.age_range','6-8 , 9-12 , 13-18');
        $this->migrator->add('structure.group_size','4 - 6');
        $this->migrator->add('structure.languages','Arabic - English');
        $this->migrator->add('structure.location','Online - Udemy');
    }
};

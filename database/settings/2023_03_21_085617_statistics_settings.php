<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('statistics.training_hours', 7823);
        $this->migrator->add('statistics.qualified_trainers',32);
        $this->migrator->add('statistics.classes_completed',459);
        $this->migrator->add('statistics.student_enrolled',1562);
        $this->migrator->add('statistics.no_of_countries',8);
        $this->migrator->add('statistics.participate_in_competition',10);
    }
};

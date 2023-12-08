<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void
    {
        $this->migrator->add('child_session_reviews.booleans', ['attendance']);
        $this->migrator->add('child_session_reviews.ratings', ['homework']);
        $this->migrator->add('child_session_reviews.texts', ['comment']);
    }
};

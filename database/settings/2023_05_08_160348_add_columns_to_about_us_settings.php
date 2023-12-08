<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('about_us.text_button',['ar'=>'احصل علي حصه مجانيه','en'=>'Get Free Session']);
        $this->migrator->add('about_us.top_header_text',[['ar'=>'مستقبل أفضل','en'=>'Better Future'],['ar'=>' معلومات أفضل','en'=>'Better Knowledge'],['ar'=>'حياه مهنيه أفضل','en'=>'Better Career'],['ar'=>' حساه أفضل','en'=>'Better Live'],]);
        $this->migrator->add('about_us.lower_header_text',['ar'=>'من أجل أطفالك','en'=>' For your kids']);

    }
};

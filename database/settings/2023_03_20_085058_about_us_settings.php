<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('about_us.image', 'https://aquadic.github.io/megamind_front/images/aboutimg.webp');
        $this->migrator->add('about_us.home_image', 'https://aquadic.github.io/megamind_front/images/aboutimg.webp');
        $this->migrator->add('about_us.description',['ar'=>'متخصص في التدريب (الروبوتات - البرمجة - التصميم الجرافيكي) للأطفال والشباب من سن 6 إلى 16 عامًا. يمر الطالب برحلة شيقة في عالم Megaminds في البرمجة والروبوتات وعلوم الجرافيك ، والتي تستمر لعدة مستويات من مبتدئ إلى محترف. من سن 6 إلى 16 سنة.','en'=>'Specialized in training (Robotics - Programming - Graphic Design) for children and young people from 6 to 16 years old.\nThe student goes through an interesting journey in the world of Megaminds in programming, robotics and graphic sciences, which continues for several levels from beginner to professional. Age 6 to 16 years.']);
        $this->migrator->add('about_us.vision',['ar'=>'بناء قادة المستقبل في مجال التكنولوجيا من خلال التعليم الترفيهي القائم على S.T.E.A.M.','en'=>'Building future technology leaders through entertaining, S.T.E.A.M based education']);
        $this->migrator->add('about_us.mission',['ar'=>'هو السعي نحو مستقبل مهني أفضل ، ومستقبل أكثر إشراقًا للطلاب في جميع أنحاء العالم من خلال الابتكار في تكنولوجيا التعليم.','en'=>'Is to strive towards a better career, and a brighter future for students worldwide through innovation in education technology.']);
        $this->migrator->add('about_us.footer_text',['ar'=>'السعي نحو مستقبل مهني أفضل ، ومستقبل أكثر إشراقًا للطلاب في جميع أنحاء العالم من خلال الابتكار في تكنولوجيا التعليم.','en'=>'Is to strive towards a better career, and a brighter future for students worldwide through innovation in education technology.']);
    }
};

<?php

namespace App\Settings;

use App\Traits\Attributes\HasPrimaryImage;
use Spatie\LaravelSettings\Settings;
use Spatie\MediaLibrary\HasMedia;

class AboutUsSettings extends Settings
{

    public array $description;

    public array $text_button;

    public array $top_header_text;

    public array $lower_header_text;


    /**
     *  home_image.
     * @var string
     */
    public string $home_image;

    /**
     * @var string
     * Image
     */
    public string $image;

    public array $vision;


    public array $mission;


    public array $footer_text;

    public static function group(): string
    {
        return 'about_us';
    }

    protected static function defaults(): array
    {
        return [
            'description' => ['ar' => 'متخصص في التدريب (الروبوتات - البرمجة - التصميم الجرافيكي) للأطفال والشباب من سن 6 إلى 16 عامًا. يمر الطالب برحلة شيقة في عالم Megaminds في البرمجة والروبوتات وعلوم الجرافيك ، والتي تستمر لعدة مستويات من مبتدئ إلى محترف. من سن 6 إلى 16 سنة.', 'en' => 'Specialized in training (Robotics - Programming - Graphic Design) for children and young people from 6 to 16 years old.\nThe student goes through an interesting journey in the world of Megaminds in programming, robotics and graphic sciences, which continues for several levels from beginner to professional. Age 6 to 16 years.'],
            'mission' => ['ar' => 'هو السعي نحو مستقبل مهني أفضل ، ومستقبل أكثر إشراقًا للطلاب في جميع أنحاء العالم من خلال الابتكار في تكنولوجيا التعليم.', 'en' => 'Is to strive towards a better career, and a brighter future for students worldwide through innovation in education technology.'],
            'footer_text' => ['ar' => 'السعي نحو مستقبل مهني أفضل ، ومستقبل أكثر إشراقًا للطلاب في جميع أنحاء العالم من خلال الابتكار في تكنولوجيا التعليم.', 'en' => 'Is to strive towards a better career, and a brighter future for students worldwide through innovation in education technology.'],
            'vision' => ['ar' => 'بناء قادة المستقبل في مجال التكنولوجيا من خلال التعليم الترفيهي القائم على S.T.E.A.M.', 'en' => 'Building future technology leaders through entertaining, S.T.E.A.M based education'],
            'image' => 'https://aquadic.github.io/megamind_front/images/aboutimg.webp',
            'home_image' => 'https://aquadic.github.io/megamind_front/images/aboutimg.webp',
            'text_button' => ['ar' => 'احصل علي حصه مجانيه', 'en' => 'Get Free Session'],
            'top_header_text' => [['ar' => 'مستقبل أفضل', 'en' => 'Better Future'], ['ar' => ' معلومات أفضل', 'en' => 'Better Knowledge'], ['ar' => 'حياه مهنيه أفضل', 'en' => 'Better Career'], ['ar' => ' حساه أفضل', 'en' => 'Better Live'],],
            'lower_header_text' => ['ar' => 'من أجل أطفالك', 'en' => ' For your kids']
        ];
    }

}

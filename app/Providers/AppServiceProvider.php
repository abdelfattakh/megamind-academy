<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\PaymentMethod;
use App\Models\SocialMedia;
use App\Settings\AboutUsSettings;
use Filament\Facades\Filament;
use FilamentQuickCreate\Facades\QuickCreate;
use FilamentStickyHeader\Facades\StickyHeader;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(AboutUsSettings $settings): void
    {
        Filament::serving(function () {
            StickyHeader::setTheme('floating');
        });

        QuickCreate::excludes([
            \App\Filament\Resources\ContactUsResource::class
        ]);

        try {
            $data = Cache::remember(
                key: 'view-data-provider-cache',
                ttl: now()->addMinutes(60),
                callback: fn() => [
                    'pages' => Page::query()->active()->get(),
                    'payment_methods' => PaymentMethod::active()->with('image')->get(),
                    'social_medias' => SocialMedia::active()->with('image')->get(),
                    'footer_text' => $settings->footer_text,
                    'home_image' => $settings->home_image,
                    'text_button' => $settings->text_button,
                    'lower_header_text' => $settings->lower_header_text,
                    'top_header_text' => $settings->top_header_text,
                ]
            );

            View::share('data', $data);
        } catch (\Exception) {
            View::share('data', [
                'pages' => collect(),
                'payment_methods' => [],
                'social_medias' => [],
                'footer_text' => [],
                'home_image' => [],
                'text_button' => [],
                'lower_header_text' => [],
                'top_header_text' => [],
            ]);
        }
    }
}

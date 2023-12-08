<?php

namespace App\Filament\Pages;

use App\Settings\ChildSessionReviewSettings;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TagsInput;
use Filament\Pages\SettingsPage;

class ManageChildSessionReview extends SettingsPage
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static string $settings = ChildSessionReviewSettings::class;

    public static function getNavigationLabel(): string
    {
        return __('admin.child_session_review_setting');
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('admin.setting');
    }

    protected function getFormSchema(): array
    {
        return [
            Card::make()
                ->schema([
                    TagsInput::make('booleans'),
                    TagsInput::make('ratings'),
                    TagsInput::make('texts'),
                ]),
        ];
    }

    protected function getHeading(): string
    {
        return __('admin.child_session_review_setting');
    }
}

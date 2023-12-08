<?php

namespace App\Filament\Pages;

use App\Settings\JoinUsSettings;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;

class ManageJoinUs extends SettingsPage
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-emoji-happy';

    protected static string $settings = JoinUsSettings::class;

    public static function getNavigationLabel(): string
    {
        return __('admin.join_us_setting');
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
                    TextInput::make('name')
                        ->label(__('admin.name'))
                        ->required(),

                    TextInput::make('description')
                        ->label(__('admin.description'))
                        ->required(),
                ]),
        ];
    }

    protected function getHeading(): string
    {
        return __('admin.join_us_setting');
    }
}

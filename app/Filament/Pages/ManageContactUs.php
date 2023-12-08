<?php

namespace App\Filament\Pages;

use App\Settings\ContactUsSettings;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;

class ManageContactUs extends SettingsPage
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-phone';

    protected static string $settings = ContactUsSettings::class;

    public static function getNavigationLabel(): string
    {
        return __('admin.contact_us_setting');
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
                    TextInput::make('address')
                        ->label(__('admin.address'))
                        ->required(),

                    TextInput::make('first_phone')
                        ->label(__('admin.first_phone'))
                        ->tel()
                        ->required(),

                    TextInput::make('second_phone')
                        ->label(__('admin.second_phone'))
                        ->tel(),

                    TextInput::make('whatsapp_phone')
                        ->label(__('admin.whatsapp_phone'))
                        ->tel()
                        ->required(),

                    TextInput::make('email')
                        ->email()
                        ->label(__('admin.email'))
                        ->required(),


                ]),

        ];
    }

    protected function getHeading(): string
    {
        return __('admin.contact_us_setting');
    }


}

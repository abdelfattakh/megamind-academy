<?php

namespace App\Filament\Pages;

use App\Settings\AboutUsSettings;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;

class ManageAboutUs extends SettingsPage
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = AboutUsSettings::class;

    public static function getNavigationLabel(): string
    {
        return __('admin.about_us_settings');
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('admin.setting');
    }

    protected function getFormSchema(): array
    {
        return [
            Card::make()
                ->columns(2)
                ->schema([
                    TextInput::make('description.en')
                        ->label(__('admin.description_en'))
                        ->required(),

                    TextInput::make('description.ar')
                        ->label(__('admin.description_ar'))
                        ->required(),

                    TextInput::make('mission.ar')
                        ->label(__('admin.mission_ar'))
                        ->required(),
                    TextInput::make('mission.en')
                        ->label(__('admin.mission_en'))
                        ->required(),
                    TextInput::make('vision.ar')
                        ->label(__('admin.vision_ar'))
                        ->required(),

                    TextInput::make('vision.en')
                        ->label(__('admin.vision_en'))
                        ->required(),

                    TextInput::make('footer_text.ar')
                        ->label(__('admin.footer_text_ar'))
                        ->required(),

                    TextInput::make('text_button.ar')
                        ->label(__('admin.text_button_ar'))
                        ->required(),

                    TextInput::make('text_button.en')
                        ->label(__('admin.text_button_en'))
                        ->required(),


                    Repeater::make('top_header_text')
                        ->schema([
                            TextInput::make('top_header_text.ar')
                                ->label(__('admin.top_header_text_ar')),

                            TextInput::make('top_header_text.en')
                                ->label(__('admin.top_header_text_en'))
                                ->columnSpanFull(),


                        ])->label(__('admin.top_header_text'))
                        ->columnSpanFull(),

                    TextInput::make('lower_header_text.ar')
                        ->label(__('admin.text_button_ar')),

                    TextInput::make('lower_header_text.en')
                        ->label(__('admin.text_button_en')),

                    FileUpload::make('image')
                        ->label(__('admin.main_image_about_us'))
                        ->required()
                        ->image(),
                    FileUpload::make('home_image')
                        ->label(__('admin.main_image_home'))
                        ->required()
                        ->image(),

                ]),
        ];
    }

    protected function getHeading(): string
    {
        return __('admin.about_us_settings');
    }
}

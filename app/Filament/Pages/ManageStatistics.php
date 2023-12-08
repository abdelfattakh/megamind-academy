<?php

namespace App\Filament\Pages;

use App\Settings\StatisticsSettings;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;

class ManageStatistics extends SettingsPage
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-chart-square-bar';

    protected static string $settings = StatisticsSettings::class;

    public static function getNavigationLabel(): string
    {
        return __('admin.statistics_setting');
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
                    TextInput::make('training_hours')
                        ->numeric()
                        ->label(__('web.training_hours'))
                        ->required(),

                    TextInput::make('qualified_trainers')
                        ->numeric()
                        ->label(__('web.qualified_trainers'))
                        ->required(),

                    TextInput::make('classes_completed')
                        ->numeric()
                        ->label(__('web.classes_completed'))
                        ->required(),

                    TextInput::make('student_enrolled')
                        ->numeric()
                        ->label(__('web.student_enrolled'))
                        ->required(),

                    TextInput::make('no_of_countries')
                        ->numeric()
                        ->label(__('web.no_of_countries'))
                        ->required(),

                    TextInput::make('participate_in_competition')
                        ->numeric()
                        ->label(__('web.participate'))
                        ->required(),
                ]),
        ];
    }

    protected function getHeading(): string
    {
        return __('admin.statistics_setting');
    }
}

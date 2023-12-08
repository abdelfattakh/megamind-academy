<?php

namespace App\Filament\Pages;

use App\Settings\ProgramStructure;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;

class ManageProgramStructure extends SettingsPage
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments';

    protected static string $settings = ProgramStructure::class;

    protected function getFormSchema(): array
    {
        return [
            Card::make()
                ->schema([

                    TextInput::make('weekly_hours')
                        ->label(__('admin.weekly_hours'))
                        ->required(),

                    TextInput::make('age_range')
                        ->label(__('admin.age_range'))
                        ->required(),

                    TextInput::make('group_size')
                        ->label(__('admin.group_size'))
                        ->required(),

                    TextInput::make('languages')
                        ->label(__('admin.languages'))
                        ->required(),

                    TextInput::make('location')
                        ->label(__('admin.locations'))
                        ->required(),


                ]),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.program_structure_setting');
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('admin.setting');
    }

    protected function getHeading(): string
    {
        return __('admin.program_structure_setting');
    }
}

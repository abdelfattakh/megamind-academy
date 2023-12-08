<?php

namespace App\Filament\Resources\AgeResource\Pages;

use App\Filament\Resources\AgeResource;
use App\Filament\Resources\CountryResource\Widgets\AgeStatusOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAges extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = AgeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),

        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AgeResource\Widgets\AgeStatusOverview::class
        ];
    }
}

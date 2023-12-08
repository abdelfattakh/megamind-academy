<?php

namespace App\Filament\Resources\PositionResource\Pages;

use App\Filament\Resources\PositionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPositions extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = PositionResource::class;

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
            PositionResource\Widgets\PositionStatusOverview::class
        ];
    }
}

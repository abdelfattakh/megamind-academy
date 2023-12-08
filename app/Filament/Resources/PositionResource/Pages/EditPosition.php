<?php

namespace App\Filament\Resources\PositionResource\Pages;

use App\Filament\Resources\PositionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPosition extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = PositionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),

        ];
    }
}

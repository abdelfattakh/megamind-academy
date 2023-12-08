<?php

namespace App\Filament\Resources\PositionResource\Pages;

use App\Filament\Resources\PositionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePosition extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = PositionResource::class;

    public function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),

        ];
    }
}

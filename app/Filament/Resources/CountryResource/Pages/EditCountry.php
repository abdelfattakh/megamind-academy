<?php

namespace App\Filament\Resources\CountryResource\Pages;

use App\Filament\Resources\CountryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCountry extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = CountryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),

        ];
    }
}

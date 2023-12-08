<?php

namespace App\Filament\Resources\CountryResource\Pages;

use App\Filament\Resources\CountryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCountry extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = CountryResource::class;

    public function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),

        ];
    }
}

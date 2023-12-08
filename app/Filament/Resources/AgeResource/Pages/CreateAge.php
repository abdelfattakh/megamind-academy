<?php

namespace App\Filament\Resources\AgeResource\Pages;

use App\Filament\Resources\AgeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAge extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = AgeResource::class;

    public function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),

        ];
    }
}

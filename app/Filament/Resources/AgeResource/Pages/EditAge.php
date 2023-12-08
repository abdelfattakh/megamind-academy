<?php

namespace App\Filament\Resources\AgeResource\Pages;

use App\Filament\Resources\AgeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAge extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = AgeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),

        ];
    }
}

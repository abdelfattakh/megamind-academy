<?php

namespace App\Filament\Resources\SessionEntryResource\Pages;

use App\Filament\Resources\SessionEntryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSessionEntry extends EditRecord
{
    protected static string $resource = SessionEntryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

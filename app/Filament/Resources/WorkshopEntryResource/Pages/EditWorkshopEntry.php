<?php

namespace App\Filament\Resources\WorkshopEntryResource\Pages;

use App\Filament\Resources\WorkshopEntryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorkshopEntry extends EditRecord
{
    protected static string $resource = WorkshopEntryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

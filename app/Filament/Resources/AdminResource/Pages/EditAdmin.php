<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use STS\FilamentImpersonate\Pages\Actions\Impersonate;

class EditAdmin extends EditRecord
{
    protected static string $resource = AdminResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Impersonate::make()
                ->record($this->getRecord())
                ->guard(config('filament.auth.guard'))
                ->redirectTo(config('filament.path')),
        ];
    }
}

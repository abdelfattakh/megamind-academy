<?php

namespace App\Filament\Resources\SocialMediaResource\Pages;

use App\Filament\Resources\SocialMediaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSocialMedia extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = SocialMediaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),

        ];
    }
}

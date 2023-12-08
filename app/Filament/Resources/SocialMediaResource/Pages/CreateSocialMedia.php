<?php

namespace App\Filament\Resources\SocialMediaResource\Pages;

use App\Filament\Resources\SocialMediaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSocialMedia extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = SocialMediaResource::class;

    public function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),

        ];
    }
}

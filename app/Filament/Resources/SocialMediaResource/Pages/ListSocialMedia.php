<?php

namespace App\Filament\Resources\SocialMediaResource\Pages;

use App\Filament\Resources\SocialMediaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSocialMedia extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = SocialMediaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),

        ];
    }
}

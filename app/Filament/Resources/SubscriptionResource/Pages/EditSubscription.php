<?php

namespace App\Filament\Resources\SubscriptionResource\Pages;

use App\Filament\Resources\SubscriptionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubscription extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = SubscriptionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),

        ];
    }
}

<?php

namespace App\Filament\Resources\SessionEntryResource\Pages;

use App\Enums\SessionTypeEnum;
use App\Filament\Resources\SessionEntryResource;
use Filament\Forms;
use Filament\Resources\Pages\CreateRecord;

class CreateSessionEntry extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = SessionEntryResource::class;

    protected function getSteps(): array
    {
        return [
            Forms\Components\Wizard\Step::make('session')
                ->label(__('admin.session_entry'))
//                ->description(__('admin.session_entry_hint'))
                ->schema(SessionEntryResource::sessionForm()),
            Forms\Components\Wizard\Step::make('review')
                ->visible(fn($get) => $get('session_type') != SessionTypeEnum::Training() )
                ->label(__('admin.Review'))
                ->schema(fn($get) => SessionEntryResource::reviewForm($get)),
        ];
    }
}

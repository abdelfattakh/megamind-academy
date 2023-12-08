<?php

namespace App\Filament\Resources\ChildResource\Pages;

use App\Filament\Resources\ChildResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListChildren extends ListRecords
{
    protected static string $resource = ChildResource::class;

    protected function getActions(): array
    {
        return [
             CreateAction::make(),
            ImportAction::make()
//                ->massCreate(false)
                ->handleBlankRows(true)
                ->fields([
                    ImportField::make('id')
                        ->label(__('admin.id') . ' ' . __('admin.id')),
                    ImportField::make('name')
                        ->label(__('admin.name')),
//                    ImportField::make('birthdate')
//                        ->label(__('admin.birthdate')),
//                    ImportField::make('address')
//                        ->label(__('admin.address')),
                ]),
        ];
    }
}

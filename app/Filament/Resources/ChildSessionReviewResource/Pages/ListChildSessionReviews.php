<?php

namespace App\Filament\Resources\ChildSessionReviewResource\Pages;

use App\Filament\Resources\ChildSessionReviewResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChildSessionReviews extends ListRecords
{
    protected static string $resource = ChildSessionReviewResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

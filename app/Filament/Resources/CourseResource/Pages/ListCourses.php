<?php

namespace App\Filament\Resources\CourseResource\Pages;

use App\Filament\Resources\CourseResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCourses extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = CourseResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),

        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CourseResource\Widgets\CourseStatusOverview::class
        ];
    }
}

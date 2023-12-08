<?php

namespace App\Filament\Resources\CourseResource\Pages;

use App\Filament\Resources\CourseResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCourse extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = CourseResource::class;

    public function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),

        ];
    }
}

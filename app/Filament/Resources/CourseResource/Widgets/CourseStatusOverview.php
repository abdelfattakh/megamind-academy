<?php

namespace App\Filament\Resources\CourseResource\Widgets;

use App\Models\Course;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class CourseStatusOverview extends BaseWidget
{

    protected function getCards(): array
    {
        return [
            Card::make('All Courses', Course::query()->count())
                ->icon('heroicon-o-flag')
                ->label(__('admin.courses')),

            Card::make('Active Courses', Course::query()->active()->count())
                ->icon('heroicon-o-check-circle')
                ->label(__('admin.active_courses')),

            Card::make('InActive Courses', Course::query()->active(false)->count())
                ->icon('heroicon-o-x-circle')
                ->label(__('admin.Inactive_courses')),
        ];
    }
}

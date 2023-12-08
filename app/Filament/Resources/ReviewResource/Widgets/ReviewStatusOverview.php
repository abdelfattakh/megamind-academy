<?php

namespace App\Filament\Resources\ReviewResource\Widgets;

use App\Models\Review;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class ReviewStatusOverview extends BaseWidget
{

    protected function getCards(): array
    {
        return [
            Card::make('All Reviews', Review::query()->count())
                ->icon('heroicon-o-user-group')
                ->label(__('admin.all_resource', ['resource' => __('admin.Reviews')])),

            Card::make('Active Reviews', Review::query()->active()->count())
                ->icon('heroicon-o-check-circle')
                ->label(__('admin.active_resource', ['resource' => __('admin.Reviews')])),

            Card::make('In Active Reviews', Review::query()->active(false)->count())
                ->icon('heroicon-o-x-circle')
                ->label(__('admin.inactive_resource', ['resource' => __('admin.Reviews')])),
        ];
    }
}

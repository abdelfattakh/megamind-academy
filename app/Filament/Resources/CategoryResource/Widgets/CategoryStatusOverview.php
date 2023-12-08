<?php

namespace App\Filament\Resources\CategoryResource\Widgets;

use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class CategoryStatusOverview extends BaseWidget
{

    /**
     * Polling Interval, null means no polling.
     *
     * @var string|null
     */


    protected function getCards(): array
    {
        return [
            Card::make('All Categories', Category::query()->count())
                ->icon('heroicon-o-location-marker')->label(__('admin.all_categories')),

            Card::make('Active Categories', Category::query()->active()->count())
                ->icon('heroicon-o-check-circle')->label(__('admin.active_categories')),

            Card::make('InActive Categories', Category::query()->active(false)->count())
                ->icon('heroicon-o-x-circle')->label(__('admin.inactive_categories')),
        ];
    }
}

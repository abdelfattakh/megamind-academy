<?php

namespace App\Filament\Resources\AgeResource\Widgets;

use App\Models\Country;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class AgeStatusOverview extends BaseWidget
{
    /**
     * Polling Interval, null means no polling.
     *
     * @var string|null
     */
    protected function getCards(): array
    {
        return [
            Card::make('All Ages', Country::query()->count())
                ->icon('heroicon-o-identification')->label(__('admin.all_ages')),

            Card::make('Active Ages', Country::query()->active()->count())
                ->icon('heroicon-o-check-circle')->label(__('admin.active_ages')),

            Card::make('InActive Ages', Country::query()->active(false)->count())
                ->icon('heroicon-o-x-circle')->label(__('admin.Inactive_ages')),
        ];
    }
}

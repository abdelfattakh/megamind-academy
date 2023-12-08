<?php

namespace App\Filament\Resources\PositionResource\Widgets;

use App\Models\Position;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class PositionStatusOverview extends BaseWidget
{

    protected function getCards(): array
    {
        return [
            Card::make('All Positions', Position::query()->count())
                ->icon('heroicon-o-flag')
                ->label(__('admin.all_positions')),

            Card::make('Active Positions', Position::query()->active()->count())
                ->icon('heroicon-o-check-circle')
                ->label(__('admin.active_positions')),

            Card::make('InActive Positions', Position::query()->active(false)->count())
                ->icon('heroicon-o-x-circle')
                ->label(__('admin.Inactive_positions')),
        ];
    }
}

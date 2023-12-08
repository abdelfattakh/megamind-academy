<?php

namespace App\Filament\Resources\CareerResource\Widgets;

use App\Models\Career;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class CareerStatusOverview extends BaseWidget
{

    protected function getCards(): array
    {
        return [
            Card::make('All careers', Career::query()->count())
                ->icon('heroicon-o-academic-cap')
                ->label(__('admin.all_careers')),


        ];
    }
}

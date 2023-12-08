<?php

namespace App\Filament\Resources\BookingResource\Widgets;

use App\Enums\CourseLocationEnum;
use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class BookingStatusOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('All Bookings', Booking::query()->count())
                ->icon('heroicon-o-presentation-chart-line')
                ->label(__('admin.all_bookings')),

            Card::make('New Bookings', Booking::query()->whereNotNull('child_id')->count())
                ->icon('heroicon-o-book-open')
                ->label(__('admin.new_bookings')),

            Card::make('Old Bookings', Booking::query()->whereNull('child_id')->count())
                ->icon('heroicon-o-badge-check')
                ->label(__('admin.old_bookings')),

            Card::make('Online Bookings', Booking::query()->where('location_of_course', CourseLocationEnum::Online())->count())
                ->icon('heroicon-o-wifi')
                ->label(__('admin.Online')),

            Card::make('Offline Bookings', Booking::query()->where('location_of_course', CourseLocationEnum::Offline())->count())
                ->icon('heroicon-o-academic-cap')
                ->label(__('admin.Offline')),
        ];
    }
}

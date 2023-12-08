<?php

namespace App\Filament\Resources\SessionEntryResource\Widgets;

use App\Enums\SessionTypeEnum;
use App\Models\SessionEntry;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Carbon;

class SessionEntryStatusOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    public Carbon|null $date;

    public function mount()
    {
        $this->date ??= Carbon::create(year: request('year', now()->year), month: request('month', now()->month));
    }

    /**
     * Polling Interval, null means no polling.
     *
     * @return array
     */
    protected function getCards(): array
    {
        $compensatory = SessionEntry::query()
            ->where('session_type', SessionTypeEnum::Compensatory())
            ->whereMonth('doc_date', $this->date)
            ->whereYear('doc_date', $this->date)
            ->count();

        $normal = SessionEntry::query()
            ->where('session_type', SessionTypeEnum::Normal())
            ->whereMonth('doc_date', $this->date)
            ->whereYear('doc_date', $this->date)
            ->count();

        return [
            Card::make(SessionTypeEnum::Compensatory()->value, $compensatory)
                ->icon('heroicon-o-identification')->label(SessionTypeEnum::Compensatory()->label),

            Card::make(SessionTypeEnum::Normal()->label, $normal)
                ->icon('heroicon-o-check-circle')->label(SessionTypeEnum::Normal()->label),
        ];
    }
}

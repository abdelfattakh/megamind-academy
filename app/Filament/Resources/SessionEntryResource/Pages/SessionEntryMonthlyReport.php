<?php

namespace App\Filament\Resources\SessionEntryResource\Pages;

use App\Enums\SessionTypeEnum;
use App\Filament\Resources\AdminResource;
use App\Filament\Resources\SessionEntryResource;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class SessionEntryMonthlyReport extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static string $resource = SessionEntryResource::class;

    protected static string $view = 'filament.resources.session-entry-resource.pages.session-entry-monthly-report';

    public Carbon|null $date;

    public function mount()
    {
        $this->date ??= Carbon::create(year: request('year', now()->year), month: request('month', now()->month));
    }

    /**
     * @return string|null
     */
    public function getSubheading(): ?string
    {
        return __('admin.date') . ': ' . now()->translatedFormat('d M, Y h:i a');
    }

    protected function getTableQuery(): Builder
    {
        return AdminResource::getEloquentQuery()
            ->role('Instructor')
            ->withCount([
                'normal_session_entries' => fn(Builder $query) => $query
                    ->whereMonth('doc_date', $this->date)
                    ->whereYear('doc_date', $this->date),
                'compensatory_session_entries' => fn(Builder $query) => $query
                    ->whereMonth('doc_date', $this->date)
                    ->whereYear('doc_date', $this->date),
                'level_finished_session_entries' => fn(Builder $query) => $query
                    ->whereMonth('doc_date', $this->date)
                    ->whereYear('doc_date', $this->date),
            ]);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\Layout\Split::make([
                Tables\Columns\TextColumn::make('id')
                    ->grow(false)
                    ->prefix("#")
                    ->label(__('admin.id'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->color(fn($record) => ($record->compensatory_session_entries_count + $record->normal_session_entries_count) ? null : 'danger')
                    ->searchable()
                    ->label(__('admin.name'))
                    ->sortable(),


                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\Layout\Panel::make([
                        Tables\Columns\Layout\Stack::make([
                            Tables\Columns\TextColumn::make('level_finished_session_entries_count')
                                ->prefix(__('admin.is_level_finished') . ': ')
                                ->color('secondary')
                                ->label(__('admin.session_entries') . ' ' . __('admin.is_level_finished')),

                            Tables\Columns\TextColumn::make('normal_session_entries_count')
                                ->prefix(SessionTypeEnum::Normal()->label . ': ')
                                ->label(__('admin.session_entries') . ' ' . SessionTypeEnum::Normal()->label),

                            Tables\Columns\TextColumn::make('compensatory_session_entries_count')
                                ->prefix(SessionTypeEnum::Compensatory()->label . ': ')
                                ->label(__('admin.session_entries') . ' ' . SessionTypeEnum::Compensatory()->label),
                        ]),
                    ])->collapsible(),

                    Tables\Columns\TextColumn::make('total_session_entries_count')
                        ->prefix(__('admin.total') . ': ')
                        ->weight('bold')
                        ->color(fn($record) => ($record->compensatory_session_entries_count + $record->normal_session_entries_count) ? 'success' : 'danger')
                        ->formatStateUsing(fn(Model $record) => $record->compensatory_session_entries_count + $record->normal_session_entries_count)
                        ->label(__('admin.session_entries') . ' ' . __('admin.total')),
                ]),
            ]),
        ];
    }

    protected function getTableFilters(): array
    {
        return [];
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            SessionEntryResource\Widgets\SessionEntryStatusOverview::class,
        ];
    }

    protected function getTitle(): string
    {
        return __('admin.sessions_report_for', ['date' => $this->date->translatedFormat('M, Y')]);
    }
}

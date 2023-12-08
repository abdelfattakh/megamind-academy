<?php

namespace App\Filament\Resources\SessionEntryResource\Pages;

use App\Filament\Resources\SessionEntryResource;
use Filament\Forms;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Carbon;

class ListSessionEntries extends ListRecords
{
    protected static string $resource = SessionEntryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('monthly_report')
                ->label(__('admin.monthly_report'))
                ->color('secondary')
                ->form([
                    Forms\Components\Group::make()
                        ->columns(2)
                        ->schema([
                            Forms\Components\Select::make('month')
                                ->columnSpan(1)
                                ->default(now()->month)
                                ->options(collect(range(1,12))->mapWithKeys(fn($v, $k) => [$v => Carbon::create(null, $v)->format('F')]))
                                ->translateLabel(),
                            Forms\Components\Select::make('year')
                                ->columnSpan(1)
                                ->default(now()->year)
                                ->options(collect(range(2022, now()->year))->mapWithKeys(fn($v, $k) => [$v => $v]))
                                ->translateLabel(),
                        ]),
                ])
                ->action(fn($data) => $this->redirect(self::$resource::getUrl('monthly_report', $data))),
        ];
    }
}

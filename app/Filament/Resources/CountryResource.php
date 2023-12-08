<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\Pages;
use App\Filament\Resources\CountryResource\Widgets\CountryStatusOverview;
use App\Models\Country;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Support\Str;
use libphonenumber\CountryCodeToRegionCodeMap;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class CountryResource extends Resource
{
    use Translatable;

    protected static ?string $model = Country::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()->label(__('admin.country_name')),

                    Forms\Components\Select::make('code')
                        ->label(__('admin.country_code'))
                        ->required()
                        ->options(
                            collect(CountryCodeToRegionCodeMap::$countryCodeToRegionCodeMap)
                                ->flatten()
                                ->mapWithKeys(fn($v, $k) => [Str::upper($v) => Str::upper($v)])
                                ->toArray(),
                        )
                        ->columnSpan(2),
                    Forms\Components\Toggle::make('is_active')->label(__('admin.is_active'))
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('admin.id'))
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(__('admin.country_name')),

                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->label('code'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->disabled(fn($record) => !Filament::auth()->user()->can('update', $record))
                    ->label(__('admin.is_active')),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.created_at'))
                    ->sortable()
                    ->toggleable()
                    ->dateTime()
                    ->toggledHiddenByDefault(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('admin.updated_at'))
                    ->sortable()
                    ->toggleable()
                    ->dateTime()
                    ->toggledHiddenByDefault(),
            ])
            ->filters([

                TernaryFilter::make('is_active')
                    ->label('Active only?')
                    ->indicator('Active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                ExportBulkAction::make(),

            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCountries::route('/'),
            'create' => Pages\CreateCountry::route('/create'),
            'edit' => Pages\EditCountry::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return __('admin.country');
    }

    public static function getPluralLabel(): string
    {
        return __('admin.countries');
    }

    public static function getWidgets(): array
    {
        return [
            CountryStatusOverview::class
        ];
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('admin.bookings');
    }

}

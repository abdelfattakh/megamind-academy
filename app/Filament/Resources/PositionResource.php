<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PositionResource\Pages;
use App\Filament\Resources\PositionResource\Widgets\PositionStatusOverview;
use App\Models\Position;
use App\Traits\Enum\Label;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\TernaryFilter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class PositionResource extends Resource
{
    use Label;
    use Translatable;

    protected static ?string $model = Position::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('admin.name'))
                            ->required(),

                        Forms\Components\Toggle::make('is_active')
                            ->label(__('admin.is_active'))
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label(__('admin.name')),

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
                ExportBulkAction::make()

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPositions::route('/'),
            'create' => Pages\CreatePosition::route('/create'),
            'edit' => Pages\EditPosition::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            PositionStatusOverview::class
        ];
    }
    protected static function getNavigationGroup(): ?string
    {
        return __('admin.careers');
    }
}

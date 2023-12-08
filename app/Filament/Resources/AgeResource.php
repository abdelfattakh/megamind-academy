<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgeResource\Pages;
use App\Filament\Resources\AgeResource\Widgets\AgeStatusOverview;
use App\Models\Age;
use App\Traits\Enum\Label;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Filters\TernaryFilter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class AgeResource extends Resource
{
    use Label;
    use Translatable;

    protected static ?string $model = Age::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function form(Form $form): Form
    {

        return $form
            ->columns(3)
            ->schema([

                Card::make()
                    ->columnSpan(fn($record) => filled($record) ? 2 : 'full')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label(__('admin.name')),
                        Forms\Components\TextInput::make('description')
                            ->required()
                            ->label(__('admin.description')),
                        SpatieMediaLibraryFileUpload::make('images')
                            ->enableDownload()
                            ->enableOpen()
                            ->responsiveImages()
                            ->label(__('admin.main_image'))
                            ->collection((new self::$model())->getPrimaryMediaCollection()),


                        Forms\Components\Toggle::make('is_active')
                            ->required()
                            ->label(__('admin.is_active')),

                    ]),
                Forms\Components\Card::make()
                    ->visible(fn($record) => filled($record))
                    ->columnSpan(1)
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label(__('admin.created_at'))
                            ->content(fn($record) => $record->created_at?->translatedFormat('d M Y, h:i a')),
                        Forms\Components\Placeholder::make('updated_at')
                            ->label(__('admin.updated_at'))
                            ->content(fn($record) => $record->updated_at?->translatedFormat('d M Y, h:i a')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('images')
                    ->label(__('admin.main_image'))
                    ->collection((new self::$model())->getPrimaryMediaCollection())
                    ->circular(),


                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label(__('admin.name')),

                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->label(__('admin.description')),

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
            'index' => Pages\ListAges::route('/'),
            'create' => Pages\CreateAge::route('/create'),
            'edit' => Pages\EditAge::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            AgeStatusOverview::class
        ];
    }
    protected static function getNavigationGroup(): ?string
    {
        return __('admin.bookings');
    }
}

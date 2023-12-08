<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CareerResource\Pages;
use App\Filament\Resources\CareerResource\Widgets\CareerStatusOverview;
use App\Models\Career;
use App\Traits\Enum\Label;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class CareerResource extends Resource
{
    use Label;

    protected static ?string $model = Career::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Select::make('position_id')
                            ->required()
                            ->relationship('position', 'name', fn($query) => $query->active())
                            ->label(__('admin.position_id')),

                        Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->maxLength(255)
                            ->label(__('admin.first_name')),

                        Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->maxLength(255)
                            ->label(__('admin.last_name')),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->label(__('admin.email')),

                        Forms\Components\TextInput::make('comment')
                            ->required()
                            ->maxLength(255)
                            ->label(__('admin.comment')),

                        SpatieMediaLibraryFileUpload::make('images')
                            ->enableDownload()
                            ->enableOpen()
                            ->label(__('admin.main_image'))
                            ->collection((new self::$model())->getPrimaryMediaCollection()),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('position.name')
                    ->url(fn($record) => filled($record?->position_id) ? PositionResource::getUrl('edit', ['record' => $record->position_id]) : null)
                    ->sortable()->searchable()->label(__('admin.position_id')),

                Tables\Columns\TextColumn::make('first_name')
                    ->label(__('admin.first_name')),

                Tables\Columns\TextColumn::make('last_name')
                    ->label(__('admin.last_name')),

                Tables\Columns\TextColumn::make('email')
                    ->label(__('admin.email')),

                Tables\Columns\TextColumn::make('comment')
                    ->limit(20)
                    ->label(__('admin.comment')),

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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCareers::route('/'),
            'create' => Pages\CreateCareer::route('/create'),
            'edit' => Pages\EditCareer::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            CareerStatusOverview::class
        ];
    }
    protected static function getNavigationGroup(): ?string
    {
        return __('admin.careers');
    }
}

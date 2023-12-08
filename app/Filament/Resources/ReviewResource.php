<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Filament\Resources\ReviewResource\Widgets\ReviewStatusOverview;
use App\Models\Review;
use App\Traits\Enum\Label;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class ReviewResource extends Resource
{
    use Label;


    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-report';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('admin.name'))
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('comment')
                            ->label(__('admin.comment'))
                            ->required(),

                        SpatieMediaLibraryFileUpload::make('images')
                            ->responsiveImages()
                            ->label(__('admin.icon'))
                            ->collection((new self::$model())->getPrimaryMediaCollection()),

                        Forms\Components\Toggle::make('is_active')
                            ->label(__('admin.is_active'))
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                SpatieMediaLibraryImageColumn::make('images')
                    ->label(__('admin.icon'))
                    ->collection((new self::$model())->getPrimaryMediaCollection())
                    ->circular(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin.name')),

                Tables\Columns\TextColumn::make('comment')
                    ->label(__('admin.comment')),

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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            ReviewStatusOverview::class
        ];
    }
    protected static function getNavigationGroup(): ?string
    {
        return __('admin.setting');
    }
}

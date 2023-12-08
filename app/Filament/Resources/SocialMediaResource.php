<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialMediaResource\Pages;
use App\Filament\Resources\SocialMediaResource\RelationManagers;
use App\Models\SocialMedia;
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
use Filament\Tables\Filters\TernaryFilter;

class SocialMediaResource extends Resource
{
    use Label;
    use Translatable;

    protected static ?string $model = SocialMedia::class;

    protected static ?string $navigationIcon = 'heroicon-o-hashtag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('admin.name'))
                            ->required(),

                        Forms\Components\TextInput::make('link')
                            ->activeUrl()
                            ->label(__('admin.link'))
                            ->required(),

                        SpatieMediaLibraryFileUpload::make('images')
                            ->label(__('admin.images'))
                            ->collection((new self::$model())->getPrimaryMediaCollection()),

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
                SpatieMediaLibraryImageColumn::make('images')
                    ->label(__('admin.images'))
                    ->collection((new self::$model())->getPrimaryMediaCollection())
                    ->circular(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin.name'))
                    ->searchable(),


                Tables\Columns\ToggleColumn::make('is_active')
                    ->disabled(fn($record) => !Filament::auth()->user()->can('update', $record))
                    ->label(__('admin.is_active')),

                Tables\Columns\TextColumn::make('link')
                    ->label(__('admin.link')),

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
            'index' => Pages\ListSocialMedia::route('/'),
            'create' => Pages\CreateSocialMedia::route('/create'),
            'edit' => Pages\EditSocialMedia::route('/{record}/edit'),
        ];
    }
    protected static function getNavigationGroup(): ?string
    {
        return __('admin.setting');
    }
}

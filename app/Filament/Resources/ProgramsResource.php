<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramsResource\Pages;
use App\Filament\Resources\ProgramsResource\RelationManagers;
use App\Models\Program;
use App\Models\Programs;
use App\Traits\Enum\Label;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProgramsResource extends Resource
{
    use Label;

    protected static ?string $model = Program::class;

    protected static ?string $navigationIcon = 'heroicon-o-desktop-computer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('admin.name'))
                            ->required(),

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

                Tables\Columns\ToggleColumn::make('is_active')
                    ->disabled(fn($record) => !Filament::auth()->user()->can('update', $record))
                    ->label(__('admin.is_active')),
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
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreatePrograms::route('/create'),
            'edit' => Pages\EditPrograms::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('admin.careers');
    }
}

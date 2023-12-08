<?php

namespace App\Filament\Resources;

use App\Enums\CourseLocationEnum;
use App\Filament\Resources\ChildResource\Pages;
use App\Filament\Resources\ChildResource\RelationManagers;
use App\Models\Child;
use App\Models\Course;
use App\Traits\Enum\Label;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ChildResource extends Resource
{
    use Label;

    protected static ?string $model = Child::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\DatePicker::make('birthdate')
                            ->label(__('admin.date_of_birth')),

                        Forms\Components\TextInput::make('address')
                            ->maxLength(255)
                            ->label(__('admin.address')),

                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->columnSpan(1)
                            ->label(__('admin.phone')),

                        Forms\Components\TextInput::make('absent_sessions_count')
                            ->numeric()
                            ->label(__('admin.absent_sessions_count')),

                        Forms\Components\TextInput::make('attended_sessions_count')
                            ->numeric()
                            ->label(__('admin.attended_sessions_count')),

                        SpatieMediaLibraryFileUpload::make('images')
                            ->columnSpanFull()
                            ->enableDownload()
                            ->enableOpen()
                            ->responsiveImages()
                            ->label(__('admin.main_image'))
                            ->acceptedFileTypes((new self::$model())->getAllowedMimeTypes())
                            ->collection((new self::$model())->getPrimaryMediaCollection()),
                    ])
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

                Tables\Columns\TextColumn::make('id')
                    ->label(__('admin.id'))
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('admin.name'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('absent_sessions_count')
                    ->counts('absent_sessions'),

                Tables\Columns\TextColumn::make('attended_sessions_count')
                    ->counts('attended_sessions'),

                Tables\Columns\TextColumn::make('birthdate')
                    ->searchable()
                    ->date(),

                Tables\Columns\TextColumn::make('address')
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label(__('admin.phone'))
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->url(fn(?Model $record) => !filled($record->phone) ? null : 'tel:' . $record->phone)
                    ->openUrlInNewTab(),


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
                Tables\Filters\Filter::make('absent_count')
                    ->form([
                        Forms\Components\TextInput::make('absent_count')
                            ->numeric(),
                    ])
                    ->query(function (array $data, Builder $query) {
                        if (!isset($data['absent_count']) || $data['absent_count'] == null) return $query;
                        return $query->has('absent_sessions', '>=', $data['absent_count']);
                    })
            ], layout: Tables\Filters\Layout::AboveContent)
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }


    public static function getRelations(): array
    {
        return [
            RelationManagers\SessionReviewsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChildren::route('/'),
            'create' => Pages\CreateChild::route('/create'),
            'edit' => Pages\EditChild::route('/{record}/edit'),
            'view' => Pages\ViewChild::route('/{record}'),
        ];
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('admin.sessions');
    }
}

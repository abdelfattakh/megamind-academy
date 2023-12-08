<?php

namespace App\Filament\Resources;

use App\Enums\CourseLocationEnum;
use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\Widgets\CourseStatusOverview;
use App\Models\Course;
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
use Filament\Tables\Columns\TextColumn;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class CourseResource extends Resource
{
    use Translatable;
    use Label;

    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-alt';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\Card::make()
                    ->columnSpan(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label(__('admin.name')),

                        Forms\Components\TextInput::make('description')
                            ->required()
                            ->label(__('admin.description')),

                        Forms\Components\Select::make('course_location')
                            ->multiple()
                            ->options(CourseLocationEnum::toArray())
                            ->required()
                            ->label(__('admin.course_location')),

                        Forms\Components\TextInput::make('udemy_course_link')
                            ->activeUrl()
                            ->label(__('web.udemy_course_link')),

                        Forms\Components\Select::make('prerequisites')
                            ->options(Course::active()->pluck('name', 'id'))
                            ->multiple()
                            ->label(__('admin.prerequisites')),


                        SpatieMediaLibraryFileUpload::make('images')
                            ->enableDownload()
                            ->enableOpen()
                            ->responsiveImages()
                            ->label(__('admin.main_image'))
                            ->acceptedFileTypes((new self::$model())->getAllowedMimeTypes())
                            ->collection((new self::$model())->getPrimaryMediaCollection()),

                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name', fn($query) => $query->active())
                            ->label(__('admin.category_id')),

                        Forms\Components\TextInput::make('session_no')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->label(__('web.session_no')),


                    ])->columns(2),

                Forms\Components\Card::make()
                    ->visible()
                    ->columnSpan(1)
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->label(__('admin.product_price')),

                        Forms\Components\TextInput::make('discount_value')
                            ->numeric()
                            ->minValue(1)
                            ->label(__('admin.discount_value')),
                        Forms\Components\DateTimePicker::make('discount_expiration_date')
                            ->nullable()
                            ->label(__('admin.discount_expiration_date')),

                    ])->columns(2),

                Forms\Components\Card::make()
                    ->columnSpan(3)
                    ->schema([
                        Forms\Components\Repeater::make('curriculum')
                            ->schema([
                                Forms\Components\TextInput::make('session_no')
                                    ->numeric()
                                    ->required()
                                    ->label(__('admin.session_no_curriculum')),

                                Forms\Components\TextInput::make('session_content')
                                    ->required()
                                    ->label(__('admin.session_content_curriculum')),
                            ])->label(__('admin.curriculum')),
                    ]),
                Forms\Components\Card::make()
                    ->columnSpan(2)
                    ->schema([
                        Forms\Components\Select::make('ages')
                            ->multiple()
                            ->required()
                            ->relationship('ages', 'name')
                            ->label(__('admin.ages')),

                        Forms\Components\TextInput::make('course_bookings')
                            ->required()
                            ->numeric()
                            ->label(__('admin.course_bookings')),

                        Forms\Components\Toggle::make('is_top_course')
                            ->label(__('web.is_top_course')),

                        Forms\Components\Toggle::make('is_active')
                            ->label(__('admin.is_active')),

                    ])->columns(2),

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

                TextColumn::make('ages.name')
                    ->url(fn($record) => filled($record) ?: AgeResource::getUrl('edit', ['record' => $record->age_id]))
                    ->sortable()->searchable()->label(__('admin.ages')),

                Tables\Columns\TextColumn::make('id')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->label(__('admin.id')),

                Tables\Columns\TextColumn::make('category.name')
                    ->url(fn($record) => filled($record?->category_id) ? CategoryResource::getUrl('edit', ['record' => $record->category_id]) : null)
                    ->sortable()->searchable()->label(__('admin.category_id')),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(__('admin.name')),

                Tables\Columns\TextColumn::make('description')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable()
                    ->sortable()
                    ->label(__('admin.description')),

                Tables\Columns\TextColumn::make('course_location')
                    ->searchable()
                    ->sortable()
                    ->label(__('admin.course_location')),
                Tables\Columns\TextColumn::make('udemy_course_link')
                    ->formatStateUsing(fn($record) => $record->udemy_course_link ?: '-')
                    ->url(fn($record) => $record->udemy_course_link ?: null)
                    ->openUrlInNewTab()
                    ->searchable()
                    ->sortable()
                    ->label(__('web.udemy_course_link')),

                Tables\Columns\TextColumn::make('price')
                    ->sortable()
                    ->searchable()
                    ->label(__('admin.price')),

                Tables\Columns\TextColumn::make('discount_value')
                    ->sortable()
                    ->searchable()
                    ->label(__('admin.discount_value')),


                Tables\Columns\TextColumn::make('discount_expiration_date')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable()
                    ->searchable()
                    ->label(__('admin.discount_expiration_date')),


                Tables\Columns\TextColumn::make('final_price')
                    ->sortable()
                    ->searchable()
                    ->label(__('admin.final_price')),
                Tables\Columns\TextColumn::make('prerequisites')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->limit(20)
                    ->label(__('admin.prerequisites')),

                Tables\Columns\TextColumn::make('curriculum')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->limit(20)
                    ->label(__('admin.curriculum')),

                Tables\Columns\ToggleColumn::make('is_top_course')
                    ->disabled(fn($record) => !Filament::auth()->user()->can('update', $record))
                    ->label(__('web.is_top_course')),

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
                Tables\Filters\TernaryFilter::make('is_active')
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
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            CourseStatusOverview::class
        ];
    }


    protected static function getNavigationGroup(): ?string
    {
        return __('admin.bookings');
    }
}

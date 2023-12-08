<?php

namespace App\Filament\Resources\ChildResource\RelationManagers;

use App\Filament\Resources\SessionEntryResource;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class SessionReviewsRelationManager extends RelationManager
{
    protected static string $relationship = 'session_reviews';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->columns(2)
                    ->disabled()
                    ->schema([
                        Forms\Components\Select::make('session_entry_id')
                            ->label(__('admin.session_entry'))
                            ->relationship('session_entry', 'id', fn($query) => SessionEntryResource::getEloquentQuery())
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Card::make()
                    ->columns(2)
                    ->disabled()
                    ->schema([
                        Forms\Components\TextInput::make('child_id')
                            ->hint(__('admin.id'))
                            ->numeric()
                            ->required()
                            ->maxLength(191)
                            ->label(__('admin.child')),

                        Forms\Components\TextInput::make('child_name')
                            ->required()
                            ->maxLength(191)
                            ->label(__('admin.child_name')),
                    ]),

                Forms\Components\Card::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\Toggle::make("attendance")
                            ->visible(fn($get) => filled($get('child_id')))
                            ->reactive()
                            ->inline(false)
                            ->default(false)
                            ->required()
                            ->columnSpanFull()
                            ->label(__("admin.attendance")),

                        Forms\Components\KeyValue::make('data')
                            ->columnSpanFull()
                            ->disableDeletingRows()
                            ->disableAddingRows()
                            ->visible(fn($get) => filled($get('child_id')) && filled($get('attendance')) && $get('attendance'))
                            ->label(__('admin.Reviews')),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('session_entry.course_id')
                    ->description(fn(Model $record) => __('admin.session_entry') . ' : ' . $record->getAttribute('session_entry_id'), 'above')
                    ->getStateUsing(fn(Model $record) => __('admin.course') . ' : ' . ($record->getRelation('session_entry')['course_id'] ?? '-') . ' / ' . ($record->getRelation('session_entry')['level_no'] ?? '-'))
                    ->label(__('admin.session_entry'))
                    ->searchable()
                    ->searchable()
                    ->sortable()
                    ->url(fn(Model $record) => $record->getAttribute('session_entry_id') ? SessionEntryResource::getUrl('view', ['record' => $record->getAttribute('session_entry_id')]): null)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('child_name')
                    ->description(fn($record) => __('admin.id') . ' : ' . $record->getAttribute('child_id'), 'above')
                    ->label(__('admin.child'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\ToggleColumn::make('attendance')
                    ->disabled(fn($record) => !Filament::auth()->user()->can('update', $record))
                    ->label(__('admin.attendance'))
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('session_entry.doc_date')
                    ->label(__('admin.created_at'))
                    ->sortable()
                    ->toggleable()
                    ->dateTime()
                    ->toggledHiddenByDefault(),

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
                DateRangeFilter::make('doc_date')
                    ->label(__('admin.doc_date'))
                    ->query(function (array $data, Builder $query) {
                        $dates = explode(' ', $data['doc_date']);
                        $from = $dates[0] ?? null;
                        $to = $dates[2] ?? null;

                        return $query
                            ->when(
                                $from !== null && $to !== null,
                                fn(Builder $query, $date): Builder => $query->whereHas('session_entry', fn($q) => $q->whereBetween('doc_date', [
                                    Carbon::createFromFormat('d/m/Y', $from)->startOfDay(),
                                    Carbon::createFromFormat('d/m/Y', $to)->endOfDay(),
                                ])),
                            );
                    })
                    ->withIndicater(),

                Tables\Filters\TernaryFilter::make('attendance')
                    ->label(__('admin.attendance'))
                    ->default(null)
                    ->trueLabel(__('admin.attended'))
                    ->falseLabel(__('admin.absent')),
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}

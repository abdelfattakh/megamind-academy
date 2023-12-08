<?php

namespace App\Filament\Resources;

use App\Enums\WorkShopStatusEnum;
use App\Filament\Resources\WorkshopEntryResource\Pages;
use App\Filament\Resources\WorkshopEntryResource\RelationManagers;
use App\Models\WorkshopEntry;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class WorkshopEntryResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = WorkshopEntry::class;

    protected static ?string $navigationIcon = 'heroicon-o-save-as';

    protected static ?int $navigationSort = 99999;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('instructor_id')
                            ->hint(__('admin.id'))
                            ->required()
                            ->label(__('admin.instructor'))
                            ->default(auth()->id())
                            ->columnSpan(fn($context) => $context == 'create' ? 2 : 1)
                            ->relationship('instructor', 'name'),
                        Forms\Components\TextInput::make('instructor_name')
                            ->nullable()
                            ->maxLength(191)
                            ->hiddenOn('create')
                            ->disabled()
                            ->label(__('admin.instructor_name')),
                    ]),

                Forms\Components\Card::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('course_id')
                            ->hint(__('admin.id'))
                            ->numeric()
                            ->required()
                            ->maxLength(191)
                            ->label(__('admin.course')),

                        Forms\Components\TextInput::make('level_no')
                            ->hint(__('admin.id'))
                            ->required()
                            ->maxLength(191)
                            ->label(__('admin.level_no')),

                        Forms\Components\TextInput::make('course_name')
                            ->nullable()
                            ->maxLength(191)
                            ->label(__('admin.course_name')),

                        Forms\Components\Select::make('status')
                            ->default(WorkShopStatusEnum::progress->value)
                            ->options(WorkShopStatusEnum::toArray())
                            ->label(__('admin.status')),
                    ]),

                Forms\Components\Card::make()
                    ->columns(2)
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

                        Forms\Components\TextInput::make('child_phone_e164')
                            ->nullable()
                            ->maxLength(191)
                            ->tel()
                            ->columnSpanFull()
                            ->label(__('admin.child_phone_e164')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('admin.id'))
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                Tables\Columns\TextColumn::make('level_no')
                    ->label(__('admin.level_no'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('instructor.name')
                    ->description(fn($record) => __('admin.id') . ' : ' . $record->getAttribute('instructor_id'), 'above')
                    ->label(__('admin.instructor'))
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->url(fn(?Model $record) => $record->instructor_id ? AdminResource::getUrl('edit', ['record' => $record->instructor_id]) : null),

                Tables\Columns\TextColumn::make('course_name')
                    ->description(fn($record) => __('admin.id') . ' : ' . $record->getAttribute('course_id'), 'above')
                    ->label(__('admin.course'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('child_name')
                    ->description(fn($record) => __('admin.id') . ' : ' . $record->getAttribute('child_id'), 'above')
                    ->label(__('admin.child'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('child_phone_e164')
                    ->label(__('admin.child_phone_e164'))
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->extraAttributes(['dir' => 'ltr'])
                    ->url(fn(?Model $record) => $record->child_phone_e164 ? ('tel:' . $record->child_phone_e164) : null),

                Tables\Columns\TextColumn::make('status')
                    ->label(__('admin.status'))
                    ->formatStateUsing(fn(?Model $record) => $record->status)// ->label
                    ->color(fn(?Model $record) => match ($record->status) {
                        WorkShopStatusEnum::pending->value, WorkShopStatusEnum::scheduling->value => 'secondary',
                        WorkShopStatusEnum::progress->value => 'primary',
                        WorkShopStatusEnum::finished->value => 'success',
                        default => 'dark',
                    })
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('day')
                    ->label(__('admin.day'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label(__('admin.start_date'))
                    ->sortable()
                    ->toggleable()
                    ->date(),

                Tables\Columns\TextColumn::make('finish_date')
                    ->label(__('admin.finish_date'))
                    ->sortable()
                    ->toggleable()
                    ->date(),

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
                Tables\Filters\SelectFilter::make('instructor_id')
                    ->visible(Filament::auth()->user()->can('view_any_workshop::entry'))
                    ->label(__('admin.instructor'))
                    ->relationship('instructor', 'name'),

                Tables\Filters\SelectFilter::make('course_id')
                    ->label(__('admin.course'))
                    ->visible(Filament::auth()->user()->can('view_any_workshop::entry') || Filament::auth()->user()->can('view_own_workshop::entry'))
                    ->options(function () {
                        return WorkshopEntry::query()
                            ->select('course_id', 'course_name')
                            ->when(
                                Filament::auth()->user()->can('view_any_workshop::entry'),
                                fn(Builder $query) => $query,
                                fn(Builder $query) => $query->where('instructor_id', Filament::auth()->id())
                            )
                            ->pluck('course_name', 'course_id')
                            ->mapWithKeys(fn($v, $k) => [$k => "$v ($k)"])
                            ->sort()
                            ->unique()
                            ->toArray();
                    }),

                Tables\Filters\SelectFilter::make('day')
                    ->options([
                        'السبت' => __('Saturday'),
                        'الاحد' => __('Sunday'),
                        'الاثنين' => __('Monday'),
                        'الثلاثاء' => __('Tuesday'),
                        'الاربعاء' => __('Wednesday'),
                        'الخميس' => __('Thursday'),
                        'الجمعة' => __('Friday'),
                    ]),

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'progress' => 'progress',
                        'schedule' => 'schedule',
                        'done' => 'done',
                    ]),

//                DateRangeFilter::make('start_date')
//                    ->label(__('admin.start_date'))
//                    ->withIndicater(),
//
//                DateRangeFilter::make('finish_date')
//                    ->label(__('admin.finish_date'))
//                    ->withIndicater(),
            ], layout: Tables\Filters\Layout::AboveContent)
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
            'index' => Pages\ListWorkshopEntries::route('/'),
            'create' => Pages\CreateWorkshopEntry::route('/create'),
            'edit' => Pages\EditWorkshopEntry::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return __('admin.workshop_entry');
    }

    public static function getPluralLabel(): string
    {
        return __('admin.workshop_entries');
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view_own', // for his own records depends on instructor id **
            'view_any', // for all and everything.
            'create_own', // creates record with only him. **
            'create_any', // creates record with any instructor.
            'update_own', // updates only him. **
            'update_any', // updates any record.
            'delete_own', // deletes only him. **
            'delete_any', // deletes any
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (Filament::auth()->user()->can('view_any_workshop::entry')) {
            return parent::getEloquentQuery();
        }

        if (Filament::auth()->user()->can('view_own_workshop::entry')) {
            return parent::getEloquentQuery()->where('instructor_id', Filament::auth()->id());
        }

        abort(403);
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('admin.sessions');
    }
}

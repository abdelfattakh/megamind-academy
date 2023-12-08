<?php

namespace App\Filament\Resources;

use App\Enums\SessionTypeEnum;
use App\Filament\Resources\SessionEntryResource\Pages;
use App\Filament\Resources\SessionEntryResource\RelationManagers;
use App\Models\SessionEntry;
use App\Models\WorkshopEntry;
use App\Settings\ChildSessionReviewSettings;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use Yepsua\Filament\Forms\Components\Rating;


class SessionEntryResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = SessionEntry::class;

    protected static ?string $navigationIcon = 'heroicon-o-annotation';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Tabs::make('sessions_reviews')
                    ->columns(1)
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('session_entry')
                            ->columns(1)
                            ->label(__('admin.session_entry'))
                            ->schema(self::sessionForm()),
                        Forms\Components\Tabs\Tab::make('reviews')
                            ->visible(fn($get) => $get('session_type') != SessionTypeEnum::Training())
                            ->columns(1)
                            ->label(__('admin.Reviews'))
                            ->schema(fn($get) => self::reviewForm($get)),
                    ])
            ]);
    }

    public static function sessionForm(): array
    {
        return [
            Forms\Components\Card::make()
                ->hidden(Filament::auth()->user()->can('create_any_session::entry'))
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('instructor_id')
                        ->hint(__('admin.id'))
                        ->required()
                        ->label(__('admin.instructor'))
                        ->disabled(!Filament::auth()->user()->can('create_any_session::entry'))
                        ->default(auth()->id())
                        ->reactive()
                        ->columnSpan(fn($context, $record) => ($context == 'create' || !filled($record?->instructor_name)) ? 2 : 1)
                        ->relationship('instructor', 'name'),
                    // fn($query) => AdminResource::getEloquentQuery()

                    Forms\Components\TextInput::make('instructor_name')
                        ->nullable()
                        ->disabled()
                        ->maxLength(191)
                        ->hidden(fn($context, $record) => $context == 'create' || !filled($record?->instructor_name))
                        ->disabled()
                        ->label(__('admin.instructor_name')),
                ]),

            Forms\Components\Card::make()
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('session_type')
                        ->reactive()
                        ->label(__('admin.session_type'))
                        ->required()
                        ->options(SessionTypeEnum::toArray()),

                    Forms\Components\Select::make('course_id')
                        ->visible(fn($get) => $get('session_type') != SessionTypeEnum::Training())
                        ->label(__('admin.course'))
                        ->disabled(fn($get) => !filled($get('instructor_id')))
                        ->reactive()
                        ->options(function ($get) {
                            if (!filled($get('instructor_id'))) return [];

                            return WorkshopEntry::query()
                                ->select('course_id', 'course_name')
                                ->where('instructor_id', $get('instructor_id'))
                                ->pluck('course_name', 'course_id')
                                ->mapWithKeys(fn($v, $k) => [$k => "$v ($k)"])
                                ->sort()
                                ->unique()
                                ->toArray();
                        }),

                    Forms\Components\DateTimePicker::make('doc_date')
                        ->label(__('admin.session_date'))
                        ->default(now()),

                    Forms\Components\Select::make('session_no')
                        ->label(__('admin.session_number'))
                        ->default(1)
                        ->required()
                        ->options(fn() => collect([1, 2, 3, 4, 5, 6])->mapWithKeys(fn($v) => [$v => $v])),

                    Forms\Components\Select::make('level_no')
                        ->visible(fn($get) => $get('session_type') != SessionTypeEnum::Training())
                        ->label(__('admin.session_level'))
                        ->default(1)
                        ->required()
                        ->options(function ($get) {
                            if (!filled($get('course_id'))) return [];

                            return WorkshopEntry::query()
                                ->select('level_no')
                                ->where('instructor_id', $get('instructor_id'))
                                ->where('course_id', $get('course_id'))
                                ->pluck('level_no')
                                ->mapWithKeys(fn($v) => [$v => $v])
                                ->sort()
                                ->unique()
                                ->toArray();
                        }),

                    Forms\Components\Select::make('is_level_finished')
                        ->label(__('admin.is_level_finished'))
                        ->default(null)
                        ->required()
                        ->options([
                            1 => '✅ ' . __('admin.finished'),
                            0 => '❌ ' . __('admin.not_yet'),
                        ]),
                ]),

            Forms\Components\Card::make()
                ->columns(2)
                ->schema([
                    Forms\Components\Textarea::make('comment')
                        ->label(__('admin.comment'))
                        ->nullable()
                        ->columnSpanFull()
                        ->maxLength(65535),
                ]),
        ];
    }

    public static function reviewForm($get): array
    {
        if (!filled($get('instructor_id'))) return [];

        $children = WorkshopEntry::query()
            ->select('child_id', 'child_name')
            ->where('instructor_id', $get('instructor_id'))
            ->where('course_id', $get('course_id'))
            ->where('level_no', $get('level_no'))
            ->pluck('child_name', 'child_id')
            ->mapWithKeys(fn($v, $k) => [$k => "$v ($k)"])
            ->sort()
            ->unique();

        $setting = new ChildSessionReviewSettings();

        return [
            Forms\Components\Card::make()
                ->columns(2)
                ->schema([
                    Forms\Components\Repeater::make('child_session_reviews')
                        ->relationship('child_session_reviews')
                        ->columnSpanFull()
                        ->columns(3)
                        ->label(__('admin.Reviews'))
                        ->minItems(0)
                        ->maxItems($children->count())
                        ->schema([
                            Forms\Components\Select::make('child_id')
                                //->required()
                                ->reactive()
                                ->label(__('admin.child'))
                                ->columnSpan(fn($get, $state) => ($state || filled($get('child_id'))) ? 2 : 3)
                                ->afterStateUpdated(fn($state, $set) => $set('child_name', collect($children)->get($state)))
                                ->options(function ($get) use ($children) {
                                    $usedChildren = collect($get('../../child_session_reviews'))->pluck('child_id');
                                    return (clone $children)->where(function ($v, $k) use ($get, $usedChildren) {
                                        return !in_array($k, $usedChildren->toArray()) || $k == $get('child_id');
                                    });
                                }),

                            Forms\Components\TextInput::make('child_name')
                                ->nullable()
                                ->disabled()
                                ->maxLength(191)
                                ->hidden(fn($context, $record) => $context == 'create' || !filled($record?->child_name))
                                ->disabled()
                                ->label(__('admin.child_name')),

                            Forms\Components\Toggle::make("attendance")
                                ->visible(fn($get) => filled($get('child_id')))
                                ->reactive()
                                ->inline(false)
                                ->default(false)
                                ->required()
                                ->columnSpan(1)
                                ->label(__("admin.attendance")),
                            Forms\Components\Group::make()
                                ->visible(fn($get) => filled($get('child_id')) && filled($get('attendance')) && $get('attendance'))
                                ->columnSpanFull()
                                ->columns(2)
                                ->schema([
                                    ...collect($setting->booleans)
                                        ->map(fn($v) => Forms\Components\Toggle::make("data.$v")
                                            ->default(false)
                                            ->columnSpan(1)
                                            ->label(__($v)))
                                        ->toArray(),
                                    ...collect($setting->ratings)
                                        ->map(fn($v) => Rating::make("data.$v")
                                            ->columnSpan(1)
                                            ->label(__($v)))
                                        ->toArray(),
                                    ...collect($setting->texts)
                                        ->map(fn($v) => Forms\Components\TextInput::make("data.$v")
                                            ->columnSpanFull()
                                            ->label(__($v)))
                                        ->toArray(),
                                ]),
                        ]),
                ]),
        ];
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

                Tables\Columns\TextColumn::make('instructor.name')
                    ->label(__('admin.instructor'))
                    ->searchable()
                    ->description(fn($record) => __('admin.id') . ' : ' . $record->getAttribute('instructor_id'), 'above')
                    ->searchable()
                    ->sortable()
                    ->url(fn($record) => $record->getAttribute('instructor_id') ? AdminResource::getUrl('edit', ['record' => $record->getAttribute('instructor_id')]) : null)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('course_id')
                    ->label(__('admin.course'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\BadgeColumn::make('session_type')
                    ->label(__('admin.session_type'))
//                    ->enum([
//                        SessionTypeEnum::Normal()->value => __('admin.normal'),
//                        SessionTypeEnum::Compensatory()->value => __('admin.compensatory'),
//                    ])
                    ->formatStateUsing(fn($state) => __('admin.' . str($state)->lower()))
                    ->color(static function (SessionTypeEnum|null $state): string {
                        if ($state?->equals(SessionTypeEnum::Normal())) return 'success';
                        if ($state?->equals(SessionTypeEnum::Compensatory())) return 'warning';
                        if ($state?->equals(SessionTypeEnum::Training())) return 'secondary';
                        return 'danger';
                    })
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('session_no')
                    ->label(__('admin.session_number'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('level_no')
                    ->label(__('admin.session_level'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\ToggleColumn::make('is_level_finished')
                    ->disabled(fn($record) => !Filament::auth()->user()->can('update', $record))
                    ->label(__('admin.is_level_finished'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('comment')
                    ->label(__('admin.comment'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('doc_date')
                    ->label(__('admin.doc_date'))
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
                    ->withIndicater(),

                Tables\Filters\SelectFilter::make('instructor_id')
                    ->visible(Filament::auth()->user()->can('view_any_session::entry'))
                    ->label(__('admin.instructor'))
                    ->relationship('instructor', 'name'),
                // fn($query) => self::getEloquentQuery()

                Tables\Filters\SelectFilter::make('session_type')
                    ->label(__('admin.session_type'))
                    ->options(SessionTypeEnum::toArray()),

                Tables\Filters\TernaryFilter::make('is_level_finished')
                    ->label(__('admin.is_level_finished'))
                    ->indicator(__('admin.is_level_finished')),

                Tables\Filters\SelectFilter::make('session_no')
                    ->label(__('admin.session_number'))
                    ->options(fn() => collect([1, 2, 3, 4, 5, 6])->mapWithKeys(fn($v) => [$v => $v])),

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
            ],
                layout: Tables\Filters\Layout::AboveContent,
            )
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\BulkAction::make('fix_session_enums')
                    ->visible(config('app.debug'))
                    ->action(function ($records) {
                        /** @var SessionEntry $record */
                        foreach ($records as $record) {
                            $record->update([
                                'session_type' =>
                                    in_array($record->getAttribute('session_type'), ['Normal', 'عاديه'])
                                        ? 'Normal'
                                        : 'Compensatory',
                            ]);
                        }
                    }),
            ])
            ->defaultSort('doc_date', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        if (Filament::auth()->user()->can('view_any_session::entry')) {
            return parent::getEloquentQuery();
        }

        if (Filament::auth()->user()->can('view_own_session::entry')) {
            return parent::getEloquentQuery()->where('instructor_id', Filament::auth()->id());
        }

        abort(403);
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
            'index' => Pages\ListSessionEntries::route('/'),
            'create' => Pages\CreateSessionEntry::route('/create'),
            'monthly_report' => Pages\SessionEntryMonthlyReport::route('/monthly_report'),
            'view' => Pages\ViewSessionEntry::route('/{record}'),
            'edit' => Pages\EditSessionEntry::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return __('admin.session_entry');
    }

    public static function getPluralLabel(): string
    {
        return __('admin.session_entries');
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

    protected static function getNavigationGroup(): ?string
    {
        return __('admin.sessions');
    }
}

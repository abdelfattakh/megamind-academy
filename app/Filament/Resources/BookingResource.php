<?php

namespace App\Filament\Resources;

use App\Enums\CourseLocationEnum;
use App\Enums\DaysEnum;
use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\Widgets\BookingStatusOverview;
use App\Models\Booking;
use App\Models\Child;
use App\Traits\Enum\Label;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use libphonenumber\CountryCodeToRegionCodeMap;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Propaganistas\LaravelPhone\PhoneNumber;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Ysfkaya\FilamentPhoneInput\PhoneInput;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;

class BookingResource extends Resource
{
    use Label;

    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Select::make('child_id')
                            ->required()
                            ->searchable()
                            ->relationship('child', 'name')
                            ->hint('Assigned Child to this Booking!')
                            ->label(__('admin.child')),

                        Select::make('category_id')
                            ->required()
                            ->relationship('category', 'name', fn($query) => $query->active())
                            ->label(__('admin.category_id')),

                        Select::make('country_id')
                            ->required()
                            ->relationship('country', 'name', fn($query) => $query->active())
                            ->label(__('admin.country_id')),

                        Select::make('subscription_id')
                            ->required()
                            ->relationship('subscription', 'name', fn($query) => $query->active())
                            ->label(__('admin.subscription_id')),

                        Forms\Components\TextInput::make('full_name')
                            ->label(__('admin.full_name'))
                            ->required()
                            ->maxLength(255),

                        Forms\Components\DatePicker::make('date_of_birth')
                            ->label(__('admin.date_of_birth'))
                            ->required(),

                        Select::make('location_of_course')
                            ->options(CourseLocationEnum::toArray())
                            ->required()
                            ->label(__('admin.location_of_course')),

                        Forms\Components\Select::make('days')
                            ->multiple()
                            ->options(DaysEnum::toArray())
                            ->required()
                            ->label(__('admin.days')),
//
                        PhoneInput::make('phone')
                            ->label(__('admin.phone'))
                            ->displayNumberFormat(PhoneInputNumberType::E164)
                            ->focusNumberFormat(PhoneInputNumberType::E164)
                            ->inputNumberFormat(PhoneInputNumberType::E164)
                            ->columnSpan(3),

                        Forms\Components\Select::make('phone_country')
                            ->required()
                            ->options(
                                collect(CountryCodeToRegionCodeMap::$countryCodeToRegionCodeMap)
                                    ->flatten()
                                    ->mapWithKeys(fn($v, $k) => [Str::upper($v) => Str::upper($v)])
                                    ->toArray(),
                            )
                            ->columnSpan(3)
                            ->label(__('admin.country_code')),

                        Forms\Components\Textarea::make('notes')
                            ->columnSpanFull()
                            ->label(__('admin.notes'))
                            ->nullable()
                            ->maxLength(255),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('child.name')
                    ->description(fn($record) => __('admin.id') . ' : ' . $record->getAttribute('child_id'), 'above')
                    ->url(fn($record) => filled($record?->child_id) ? ChildResource::getUrl('view', ['record' => $record->child_id]) : null)
                    ->toggleable()
                    ->sortable()
                    ->searchable()
                    ->label(__('admin.child')),

                TextColumn::make('subscription.name')
                    ->url(fn($record) => filled($record?->subscription_id) ? SubscriptionResource::getUrl('edit', ['record' => $record->subscription_id]) : null)
                    ->toggleable()
                    ->sortable()
                    ->searchable()
                    ->label(__('admin.subscription_id')),

                TextColumn::make('country.name')
                    ->url(fn($record) => filled($record?->country_id) ? CountryResource::getUrl('edit', ['record' => $record->country_id]) : null)
                    ->toggleable()
                    ->sortable()
                    ->searchable()
                    ->label(__('admin.country_id')),

                TextColumn::make('category.name')
                    ->url(fn($record) => filled($record?->category_id) ? CategoryResource::getUrl('edit', ['record' => $record->category_id]) : null)
                    ->toggleable()
                    ->sortable()
                    ->searchable()
                    ->label(__('admin.category_id')),

                Tables\Columns\TextColumn::make('full_name')
                    ->toggleable()
                    ->label(__('admin.full_name')),

                Tables\Columns\TextColumn::make('date_of_birth')
                    ->toggleable()
                    ->label(__('admin.date_of_birth'))
                    ->date(),

                Tables\Columns\TextColumn::make('location_of_course')
                    ->toggleable()
                    ->formatStateUsing(fn(string $state) => __($state))
                    ->label(__('admin.location_of_course')),

                Tables\Columns\TagsColumn::make('days')
                    ->getStateUsing(fn($record) => collect($record->days)->map(fn($v) => $v->label)->toArray())
                    ->toggleable()
                    ->label(__('admin.days')),

                Tables\Columns\TextColumn::make('phone')
                    ->formatStateUsing(fn(PhoneNumber|null $state) => $state ? "[{$state->getCountry()}] / {$state->formatNational()}" : null)
                    ->tooltip(fn($record) => $record->phone_e164 ?: null)
                    ->label(__('admin.phone'))
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->url(fn(?Model $record) => !filled($record->phone_normalized) ? null : 'tel:' . $record->phone_normalized)
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
                Tables\Filters\TernaryFilter::make('child_id')
                    ->label(__('admin.status'))
                    ->placeholder('All')
                    ->trueLabel('New Only')
                    ->falseLabel('Old Only')
                    ->queries(
                        true: fn(Builder $query) => $query->whereNull('child_id'),
                        false: fn(Builder $query) => $query->whereNotNull('child_id'),
                        blank: fn(Builder $query) => $query,
                    ),
                Tables\Filters\SelectFilter::make('location_of_course')
                    ->options(CourseLocationEnum::toArray())
                    ->label(__('admin.location_of_course')),
                Tables\Filters\SelectFilter::make('country_id')
                    ->relationship('country', 'name')
                    ->label(__('admin.country')),
                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label(__('admin.category')),
                Tables\Filters\SelectFilter::make('subscription_id')
                    ->relationship('subscription', 'name')
                    ->label(__('admin.subscription')),
            ], layout: Tables\Filters\Layout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('convert_to_child')
                    ->label(__('admin.make_child'))
                    ->visible(fn(Booking $record) => !filled($record->getAttribute('child_id')))
                    ->action(function (Booking $record) {
                        $child = Child::query()->create([
                            'name' => $record->getAttribute('full_name'),
                            'birthdate' => $record->getAttribute('date_of_birth'),
                            'phone' => $record->getAttribute('phone'),
                            'phone_country' => $record->getAttribute('phone_country'),
                        ]);
                        $record->update(['child_id' => $child->getKey()]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                ExportBulkAction::make()->exports([
                    ExcelExport::make()->withColumns([
                        // ID.
                        Column::make('child_id'),
                        Column::make('created_at')->formatStateUsing(fn(Carbon $state) => $state->format('Y-m-d')),
                        Column::make('date_of_birth')->formatStateUsing(fn(Carbon $state) => $state->format('Y-m-d')),

                        Column::make('full_name'),

                        Column::make('country.name'),

                        // Phone
                        Column::make('phone')->formatStateUsing(function (Model $record) {
                            return ($record->phone_e164 ?? $record->phone) . " ";
                        })
                            ->format(NumberFormat::FORMAT_TEXT),

                        Column::make('category.name'),

                        Column::make('hometown')->formatStateUsing(fn(Model $record) => $record->country?->name),
                        Column::make('location_of_course'),
                        Column::make('days'),

                        Column::make('about_us')->formatStateUsing(fn() => null),
                        Column::make('notes')->formatStateUsing(fn() => null),
                        Column::make('age')->formatStateUsing(fn(Model $record) => $record->getAttribute('date_of_birth')->diffInYears(now())),
                        Column::make('status')->formatStateUsing(fn() => 'Waiting'),
                        Column::make('ta3akdat')->formatStateUsing(fn() => null),
                        Column::make('subscription.price'),
                    ])
                        ->askForFilename("Megaminds-System-Bookings-" . now()->toDateString())
                        ->askForWriterType(Excel::XLSX)
                        ->queue()
                        ->withChunkSize(100),
                ]),
            ])->appendHeaderActions([
                ExportAction::make()->exports([
                    ExcelExport::make()->withColumns([
                        // ID.
                        Column::make('child_id'),
                        Column::make('created_at')->formatStateUsing(fn(Carbon $state) => $state->format('Y-m-d')),
                        Column::make('date_of_birth')->formatStateUsing(fn(Carbon $state) => $state->format('Y-m-d')),

                        Column::make('full_name'),

                        Column::make('country.name'),

                        // Phone
                        Column::make('phone')->formatStateUsing(function (Model $record) {
                            return ($record->phone_e164 ?? $record->phone) . " ";
                        })
                            ->format(NumberFormat::FORMAT_TEXT),

                        Column::make('category.name'),

                        Column::make('hometown')->formatStateUsing(fn(Model $record) => $record->country?->name),
                        Column::make('location_of_course'),
                        Column::make('days'),

                        Column::make('about_us')->formatStateUsing(fn() => null),
                        Column::make('notes')->formatStateUsing(fn() => null),
                        Column::make('age')->formatStateUsing(fn(Model $record) => $record->getAttribute('date_of_birth')->diffInYears(now())),
                        Column::make('status')->formatStateUsing(fn() => 'Waiting'),
                        Column::make('ta3akdat')->formatStateUsing(fn() => null),
                        Column::make('subscription.price'),
                    ])
                        ->askForFilename("Megaminds-System-Bookings-" . now()->toDateString())
                        ->askForWriterType(Excel::XLSX)
                        ->queue()
                        ->withChunkSize(100),
                ]),
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            BookingStatusOverview::class
        ];
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('admin.bookings');
    }
}

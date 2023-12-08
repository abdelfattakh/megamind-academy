<?php

namespace App\Filament\Resources;

use Akaunting\Money\Currency;
use App\Filament\Resources\PaymentMethodResource\Pages;
use App\Filament\Resources\PaymentMethodResource\RelationManagers;
use App\Models\PaymentMethod;
use App\Traits\Enum\Label;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Ysfkaya\FilamentPhoneInput\PhoneInput;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;

class PaymentMethodResource extends Resource
{
    use Label;
    use Translatable;

    protected static ?string $model = PaymentMethod::class;

    protected static ?string $navigationIcon = 'heroicon-o-cash';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([

                Card::make()
                    ->columnSpan(fn($record) => filled($record) ? 2 : 'full')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label(__('admin.name')),

                        Forms\Components\TextInput::make('phone')
                            ->required()
                            ->tel()
                            ->label(__('admin.phone')),


                        Forms\Components\TextInput::make('link')
                            ->activeUrl()
                            ->label(__('admin.link')),


                        Forms\Components\Fieldset::make('bank_account')
                            ->label(__('admin.bank_account'))
                            ->columnSpanFull()
                            ->schema([

                                Forms\Components\Repeater::make('account_no')
                                    ->columnSpanFull()
                                    ->schema([
                                        Forms\Components\TextInput::make('account_no')
                                            ->label(__('admin.account_no'))
                                            ->nullable(),

                                        Forms\Components\Select::make('currency')
                                            ->requiredWith('account_no')
                                            ->options(collect(Currency::getCurrencies())->mapWithKeys(fn($v, $k) => [$k => $k])->toArray())
                                            ->label(__('admin.currency'))
                                            ->nullable(),
                                    ])->label(__('admin.bank_account'))
                                    ->columns(2),


                            ]),
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


                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label(__('admin.name')),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->label(__('admin.phone')),


                Tables\Columns\TextColumn::make('link')
                    ->limit(30)
                    ->searchable()
                    ->label(__('admin.link')),


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
                TernaryFilter::make('is_active')
                    ->label('Active only?')
                    ->indicator('Active'),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
//                Tables\Actions\ViewAction::make(),

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
            'index' => Pages\ListPaymentMethods::route('/'),
            'create' => Pages\CreatePaymentMethod::route('/create'),
//            'view' => Pages\ViewPaymentMethod::route('/{record}'),
            'edit' => Pages\EditPaymentMethod::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('admin.bookings');
    }
}

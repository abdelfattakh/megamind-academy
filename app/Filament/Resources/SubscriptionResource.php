<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionResource\Pages;
use App\Filament\Resources\SubscriptionResource\RelationManagers;
use App\Models\Subscription;
use App\Traits\Enum\Label;
use Filament\Forms;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class SubscriptionResource extends Resource
{
    use Translatable;
    use Label;

    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label(__('admin.name')),

                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->required()
                            ->label(__('admin.price')),

                        Forms\Components\TextInput::make('discount_price')
                            ->numeric()
                            ->label(__('admin.discount_price')),

                        Forms\Components\TextInput::make('currency')
                            ->required()
                            ->label(__('admin.currency')),

                        Forms\Components\Repeater::make('benefits')
                            ->schema([
                                Forms\Components\TextInput::make('desc')
                                    ->required()
                                    ->label(__('admin.name')),
                            ])
                            ->required(),

                        Forms\Components\Toggle::make('is_active')
                            ->label(__('admin.is_active'))
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label(__('admin.name')),
                Tables\Columns\TextColumn::make('price')
                    ->searchable()
                    ->label(__('admin.price')),

                Tables\Columns\TextColumn::make('discount_price')
                    ->searchable()
                    ->label(__('admin.discount_price')),

                Tables\Columns\TextColumn::make('currency')
                    ->label(__('admin.currency')),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label(__('admin.is_active')),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('admin.created_at'))
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('admin.updated_at'))
                    ->dateTime(),

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
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('admin.bookings');
    }
}

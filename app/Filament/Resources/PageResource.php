<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use App\Traits\Enum\Label;
use Filament\Forms;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;

class PageResource extends Resource
{
    use Label;
    use Translatable;

    protected static ?string $model = Page::class;

    protected static ?int $navigationSort = 80;

    protected static ?string $navigationIcon = 'heroicon-o-speakerphone';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(4)
            ->schema([
                Forms\Components\Card::make()
                    ->columns(4)
                    ->columnSpan(3)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(__('admin.title'))
                            ->columnSpanFull()
                            ->required(),

                        Forms\Components\RichEditor::make('description')
                            ->label(__('admin.description'))
                            ->columnSpanFull()
                            ->required(),
                    ]),
                Forms\Components\Card::make()
                    ->columns(1)
                    ->columnSpan(1)
                    ->schema([
                        Forms\Components\Placeholder::make('metadata')
                            ->columnSpan(1)
                            ->label(__('admin.metadata')),
                        Forms\Components\Placeholder::make('id')
                            ->columnSpan(1)
                            ->label(__('admin.id'))
                            ->content(fn(?Model $record) => $record?->getKey() ?? '-'),

                        Forms\Components\Select::make('shows')
                            ->multiple()
                            ->options([
                                'important_links' => __('admin.important_links'),
                                'contact_us' => __('admin.contact_us'),
                            ])
                            ->label(__('admin.show'))
                            ->columnSpan(1),

                        Forms\Components\Toggle::make('is_active')
                            ->label(__('admin.is_active'))
                            ->inlineLabel()
                            ->inline()
                            ->columnSpan(1),

                        Forms\Components\Placeholder::make('created_at')
                            ->columnSpan(1)
                            ->label(__('admin.created_at'))
                            ->content(fn(?Model $record) => ($record?->created_at ?? now())->translatedFormat('d M Y, h:i a')),
                        Forms\Components\Placeholder::make('updated_at')
                            ->columnSpan(1)
                            ->label(__('admin.updated_at'))
                            ->content(fn(?Model $record) => ($record?->created_at ?? now())->translatedFormat('d M Y, h:i a')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->toggleable()
                    ->label(__('admin.title')),

                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->label(__('admin.description')),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label(__('admin.is_active'))
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->label(__('admin.created_at'))
                    ->dateTime(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->toggleable()
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('admin.setting');
    }
}

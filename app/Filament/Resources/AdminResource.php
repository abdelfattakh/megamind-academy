<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Filament\Resources\AdminResource\Widgets\AdminStatusOverview;
use App\Models\Admin;
use App\Rules\UniqueInternationalPhone;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Nette\NotImplementedException;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label(__('admin.name')),

                        Forms\Components\TextInput::make('email')
                            ->unique(ignoreRecord: true)
                            ->label(__('admin.email'))
                            ->disabled(fn(?Admin $record): bool => filled($record))
                            ->hint(fn(?Admin $record): ?string => filled($record) ? ($record->hasVerifiedEmail() ? 'Verified' : 'Un-Verified') : null)
                            ->hintIcon(fn(?Admin $record): ?string => filled($record) ? ($record->hasVerifiedEmail() ? 'heroicon-o-shield-check' : 'heroicon-o-shield-exclamation') : null)
                            ->hintColor(fn(?Admin $record): ?string => filled($record) ? ($record->hasVerifiedEmail() ? 'success' : 'danger') : null)
                            ->hintAction(fn(?Admin $record): ?Action => filled($record) && !$record->hasVerifiedEmail() ? self::getEmailSendAction($record) : null)
                            ->suffixAction(fn(?Admin $record, Closure $set): ?Action => filled($record) ? self::getEmailEditAction($record, $set) : null)
                            ->email()
                            ->required(),

                        Forms\Components\Select::make('phone_country')
                            ->requiredWith('phone')
                            ->label(__('admin.country'))
                            ->options(get_cached_countries()->pluck('name', 'code'))
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('phone')
                            ->rule(fn(?Model $record) => new UniqueInternationalPhone((new Admin())->getTable(), $record?->getKey()))
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('password')
                            ->label(__('admin.password'))
                            ->dehydrated(fn($state) => filled($state))
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->required(fn(string $context): bool => $context === 'create')
                            ->confirmed()
                            ->password()
                            ->minLength(8)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('password_confirmation')
                            ->dehydrated(fn($state) => filled($state))
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->required(fn(string $context): bool => $context === 'create')
                            ->password()
                            ->minLength(8)
                            ->maxLength(255)
                            ->label(__('admin.password_confirmation')),

                        Forms\Components\Select::make('roles')
                            ->preload()
                            ->multiple()
                            ->label(__('filament-shield::filament-shield.resource.label.roles'))
                            ->relationship('roles', 'name'),

                    ]),
            ])
            ->columns(2);
    }

    public static function getEmailSendAction(?Admin $record): ?Action
    {
        if (!filled($record)) {
            return null;
        }

        return Action::make('send_verify_email')
            ->icon('heroicon-o-at-symbol')
            ->action(function () use ($record) {
                $record->sendEmailVerificationNotification();
                Notification::make('send_verify_email')
                    ->success()
                    ->icon('heroicon-o-shield-check')
                    ->title('Verification Email')
                    ->body('new Verification email sent to: ' . $record->email)
                    ->send();
            });
    }

    public static function getEmailEditAction(?Admin $record, Closure $set): ?Action
    {
        if (!filled($record)) {
            return null;
        }

        return Action::make('edit_email')
            ->icon('heroicon-o-pencil-alt')
            ->form([
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->default($record->email),
                Select::make('verification')
                    ->required()
                    ->default('send_verification_email')
                    ->options([
                        'mark_as_verified' => 'Change and Mark as Verified Now',
                        'send_verification_email' => 'Change and Send Verification Email',
                        'send_new_email_change_request' => 'Send new Email Change Request',
                    ]),
            ])
            ->action(function ($data) use ($record, $set) {
                if ($data['verification'] != 'send_new_email_change_request') {
                    $record->update(['email' => $data['email'], 'email_verified_at' => null]);
                    $set('email', $data['email']);
                } else {
                    $record->newEmail($data['email']);
                    throw new NotImplementedException();
                }

                match ($data['verification']) {
                    'mark_as_verified' => $record->markEmailAsVerified(),
                    'send_verification_email' => $record->sendEmailVerificationNotification(),
                    'send_new_email_change_request' => throw new NotImplementedException(),
                    default => throw ValidationException::withMessages(['verification' => __('validation.required', ['attribute' => 'verification'])]),
                };

                Notification::make('email_changed')
                    ->title('Email Alert')
                    ->body('Your email has been ' . ($data['verification'] != 'send_new_email_change_request' ? 'changed' : 'requested to change') . ' to: ' . $data['email'])
                    ->sendToDatabase($record);

                Notification::make('email_changed')
                    ->title('Email Alert')
                    ->body('email has been ' . ($data['verification'] != 'send_new_email_change_request' ? 'changed' : 'requested to change') . ' to: ' . $data['email'])
                    ->send();
            });
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('admin.id'))
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->toggleable()
                    ->label(__('admin.name')),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable()
                    ->label(__('admin.email')),

                IconColumn::make('email_verified_at')
                    ->options([
                        'heroicon-o-check-circle' => fn($state): bool => filled($state),
                        'heroicon-o-x-circle' => fn($state): bool => !filled($state),
                    ])
                    ->colors([
                        'success' => fn($state): bool => filled($state),
                        'danger' => fn($state): bool => !filled($state),

                    ])
                    ->label(__('admin.email_verified_at'))
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                Tables\Columns\TextColumn::make('phone')
                    ->label(__('admin.phone'))
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->url(fn(?Model $record) => !filled($record->phone) ? null : 'tel:' . $record->phone)
                    ->openUrlInNewTab(),

                Tables\Columns\IconColumn::make('phone_verified_at')
                    ->label(__('admin.phone_verified'))
                    ->alignCenter()
                    ->boolean()
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->toggleable()
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Impersonate::make()
                    ->guard(config('filament.auth.guard'))
                    ->redirectTo(config('filament.path')),
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
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return __('admin.admin');
    }

    public static function getPluralLabel(): string
    {
        return __('admin.admins') . ' & ' . __('admin.instructors');
    }


    protected static function getNavigationGroup(): ?string
    {
        return __('filament-shield::filament-shield.nav.group');
    }
}

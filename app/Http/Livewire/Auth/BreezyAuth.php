<?php

namespace App\Http\Livewire\Auth;

use App\Models\City;
use App\Models\Country;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Livewire\Component;
use Phpsa\FilamentPasswordReveal\Password;

class BreezyAuth extends \JeffGreco13\FilamentBreezy\Http\Livewire\Auth\Login
{
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->label(__('filament::login.fields.email.label'))
                ->email()
                ->required()
                ->autocomplete(),

            Password::make('password')
                ->label(__('filament::login.fields.password.label'))
                ->password()
                ->required(),
                
            Checkbox::make('remember')
                ->label(__('filament::login.fields.remember.label')),
        ];
    }
}

<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Child;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('convert_to_child')
                ->label(__('admin.make_child'))
                ->visible(!filled($this->getRecord()->getAttribute('child_id')))
                ->action(function () {
                    $child = Child::query()->create([
                        'name' => $this->getRecord()->getAttribute('full_name'),
                        'birthdate' => $this->getRecord()->getAttribute('date_of_birth'),
                        'phone' => $this->getRecord()->getAttribute('phone'),
                        'phone_country' => $this->getRecord()->getAttribute('phone_country'),
                    ]);
                    $this->getRecord()->update(['child_id' => $child->getKey()]);
                    $this->fillForm();
                }),
        ];
    }
}

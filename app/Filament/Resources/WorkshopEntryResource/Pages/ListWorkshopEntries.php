<?php

namespace App\Filament\Resources\WorkshopEntryResource\Pages;

use App\Filament\Resources\WorkshopEntryResource;
use App\Models\Admin;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListWorkshopEntries extends ListRecords
{
    protected static string $resource = WorkshopEntryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
//                ->massCreate(false)
                ->handleBlankRows(true)
                ->fields([
                    ImportField::make('course_id')
                        ->label(__('admin.id') . ' ' . __('admin.course')),
                    ImportField::make('course_name')
                        ->label(__('admin.course_name')),
                    ImportField::make('level_no')
                        ->label(__('admin.id') . ' ' . __('admin.level_no')),
//                    ImportField::make('workshop_name')
//                        ->label(__('admin.workshop_name')),
                    ImportField::make('instructor_id')
                        ->label(__('admin.id') . ' ' . __('admin.instructor')),
                    ImportField::make('instructor_name')
                        ->label(__('admin.instructor_name')),
                    ImportField::make('child_id')
                        ->label(__('admin.id') . ' ' . __('admin.child')),
                    ImportField::make('child_name')
                        ->label(__('admin.child_name')),
                    ImportField::make('child_phone_e164')
                        ->label(__('admin.child_phone_e164')),
                    ImportField::make('status')
                        ->label(__('admin.status')),
                ])
                ->mutateAfterCreate(function (Model $model, $row) {
                    if (isset($row['instructor_id']) && filled($row['instructor_id'])) return $model;
                    $admin = Admin::query()->select('id')
                        ->where('name', $model->getAttribute('instructor_name'))
                        ->first();
                    if (!filled($admin)) return $model;
                    $model->update(['instructor_id' => $admin->getKey()]);
                    return $model;
                }),
        ];
    }
}

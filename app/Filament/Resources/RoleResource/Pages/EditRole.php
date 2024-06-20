<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use App\Models\Permission;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return RoleResource::mutateDateForPermissions($data);
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        /** @var Role $record */
        //
        parent::handleRecordUpdate($record, $data);

        $permissionIds = Permission::whereIn('name', $data['permissions'])->pluck('id');

        $record->permissions()->sync($permissionIds);

        return $record;
    }
}

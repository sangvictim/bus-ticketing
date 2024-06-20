<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use App\Models\Permission;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return RoleResource::mutateDateForPermissions($data);
    }


    protected function handleRecordCreation(array $data): Model
    {
        /** @var Role $record */
        //
        $record = parent::handleRecordCreation($data);

        $permissionIds = Permission::whereIn('name', $data['permissions'])->pluck('id');

        $record->permissions()->sync($permissionIds);

        return $record;
    }
}

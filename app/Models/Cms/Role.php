<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    use HasFactory, LogsActivity;

    protected string $identifiableAttribute = 'name';

    protected $fillable = [
        'name',
        'guard_name',
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->useLogName('Role')
            ->setDescriptionForEvent(fn(string $eventName) => "Role {$this->name} has been {$eventName}");
    }
}

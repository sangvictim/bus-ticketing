<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Armada extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'code',
        'manufacturer',
        'production_year',
        'capacity',
        'status',
    ];

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classes::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'armada_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->useLogName('Armada')
            ->setDescriptionForEvent(fn (string $eventName) => "Armada {$this->name} has been {$eventName}");
    }
}

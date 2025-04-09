<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Buses extends Model
{
    use HasFactory, LogsActivity, HasUlids;

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
        return $this->hasMany(Schedule::class, 'bus_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->useLogName('Armada')
            ->setDescriptionForEvent(fn(string $eventName) => "Armada {$this->name} has been {$eventName}");
    }
}

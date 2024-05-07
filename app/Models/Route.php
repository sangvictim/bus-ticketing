<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Route extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'destination_city',
        'origin_city',
        'estimated_duration',
        'isActive',
    ];

    public function originCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'origin_city');
    }

    public function destinationCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'destination_city');
    }

    public function getEstimatedAttribute(): string
    {
        $menit = $this->estimated_duration;
        $jam = floor($menit / 60);
        $sisaMenit = $menit % 60;

        return $jam . 'h' . ' ' . $sisaMenit . 'm';
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'route_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->useLogName('Route')
            ->setDescriptionForEvent(fn (string $eventName) => "Route {$this->name} has been {$eventName}");
    }
}

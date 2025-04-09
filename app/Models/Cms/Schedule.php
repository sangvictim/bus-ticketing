<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Schedule extends Model
{
    use HasFactory, LogsActivity, HasUlids;

    protected $fillable = [
        'route_id',
        'buses_id',
        'departure_time',
        'arrival_time',
    ];

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function buses(): BelongsTo
    {
        return $this->belongsTo(Buses::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->useLogName('Schedule')
            ->setDescriptionForEvent(fn(string $eventName) => "Schedule {$this->name} has been {$eventName}");
    }
}

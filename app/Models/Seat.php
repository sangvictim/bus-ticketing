<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Seat extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'seat_number',
        'description',
        'isActive',
    ];

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classes::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->useLogName('Seat')
            ->setDescriptionForEvent(fn (string $eventName) => "Seat {$this->name} has been {$eventName}");
    }
}

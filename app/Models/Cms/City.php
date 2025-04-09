<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class City extends Model
{
    /** @use HasFactory<\Database\Factories\Cms\CityFactory> */
    use HasFactory, LogsActivity, HasUlids;

    protected $fillable = [
        'name',
    ];

    public function agents(): HasMany
    {
        return $this->hasMany(Agent::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->useLogName('City')
            ->setDescriptionForEvent(fn(string $eventName) => "City {$this->name} has been {$eventName}");
    }
}

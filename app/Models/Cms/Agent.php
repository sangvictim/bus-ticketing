<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Agent extends Model
{
    use HasFactory;
    use LogsActivity, HasUlids;

    protected $fillable = [
        'city_id',
        'name',
        'address',
        'contact_name',
        'mobile_phone',
        'isActive',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->useLogName('Agent')
            ->setDescriptionForEvent(fn(string $eventName) => "Agent {$this->name} has been {$eventName}");
    }
}

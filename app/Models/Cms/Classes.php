<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Classes extends Model
{
    /** @use HasFactory<\Database\Factories\Cms\ClassesFactory> */
    use HasFactory, LogsActivity, HasUlids;

    protected $fillable = [
        'name',
    ];

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class);
    }

    public function seats(): BelongsToMany
    {
        return $this->belongsToMany(Seat::class);
    }

    public function price()
    {
        return $this->hasOne(Price::class, 'class_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->useLogName('Classes')
            ->setDescriptionForEvent(fn(string $eventName) => "Classes {$this->name} has been {$eventName}");
    }
}

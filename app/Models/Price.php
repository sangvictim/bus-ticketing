<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Price extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'route_id',
        'class_id',
        'name',
        'price',
        'cut_of_price',
        'discount',
        'discount_type',
        'start_date',
        'end_date',
    ];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->useLogName('Price')
            ->setDescriptionForEvent(fn (string $eventName) => "Price {$this->name} has been {$eventName}");
    }
}

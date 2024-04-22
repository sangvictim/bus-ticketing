<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_id',
        'armada_id',
        'departure_time',
        'arrival_time',
    ];

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function armada(): BelongsTo
    {
        return $this->belongsTo(Armada::class);
    }

    public function price(): BelongsTo
    {
        return $this->belongsTo(Price::class);
    }

    public function classes(): BelongsTo
    {
        return $this->belongsTo(Classes::class);
    }
}

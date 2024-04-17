<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Route extends Model
{
    use HasFactory;

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

    public function armada(): BelongsToMany
    {
        return $this->belongsToMany(Armada::class);
    }
}

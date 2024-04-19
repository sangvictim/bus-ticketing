<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Armada extends Model
{
    use HasFactory;

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

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'armada_id', 'id');
    }
}

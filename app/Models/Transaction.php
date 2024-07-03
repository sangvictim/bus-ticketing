<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'user_id',
        'transaction_code',
        'status',
        'total_price',
        'price',
        'discount',
        'discount_type',
        'origin_city',
        'destination_city',
        'armada_code',
        'armada_name',
        'armada_class',
        'armada_seat',
        'departure',
        'checkin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function originCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'origin_city');
    }

    public function destinationCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'destination_city');
    }

    public function armadaClass(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'armada_class');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'user_id',
        'transaction_code',
        'payment_method',
        'status',
        'total_amount',
        'qty_passanger',
        'origin_city',
        'destination_city',
        'departure',
        'checkin',
        'checkout'
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

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method');
    }

    public function details(): HasMany
    {
        return $this->hasMany(TransactionDetails::class);
    }
}

<?php

namespace App\Models;

use Closure;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'user_id',
    ];

    protected static function booted(): void
    {
        // static::creating(self::onCreating());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function onCreating(): Closure
    {
        return function (self $transaction) {
            $transaction->user_id = auth()->user()->id;
            $transaction->transaction_code = 'TRIP-' . microtime(true);
        };
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

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
}

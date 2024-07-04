<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'transaction_id',
        'passager_name',
        'price',
        'armada_code',
        'armada_name',
        'armada_class',
        'seat_number',
    ];
}

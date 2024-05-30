<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'external_id',
        'user_id',
        'transaction_id',
        'channel',
        'code',
        'name',
        'account_number',
        'status',
        'expected_amount'
    ];
}

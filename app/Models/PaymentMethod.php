<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    public $fillable = [
        'parent',
        'icon',
        'name',
        'code',
        'country',
        'currency',
        'isActivated',
        'sort',
    ];

    public function parents()
    {
        return $this->belongsTo(PaymentMethod::class, 'parent');
    }

    public function childrens()
    {
        return $this->hasMany(PaymentMethod::class, 'parent');
    }
}

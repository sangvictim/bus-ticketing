<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory, HasUlids;

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

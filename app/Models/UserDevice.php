<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'authToken',
        'platform', // ios, android, web
        'userAgent',
        'fcmToken',
        'fingerprint',
    ];
}

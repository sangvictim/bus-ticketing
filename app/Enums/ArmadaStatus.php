<?php

namespace App\Enums;

enum ArmadaStatus: string
{
    case ACTIVE = 'ACTIVE';
    case RESERVED = 'RESERVED';
    case MAINTENANCE = 'MAINTENANCE';
    case OFF = 'OFF';
}

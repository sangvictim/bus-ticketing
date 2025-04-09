<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Models\Activity as ModelsActivity;
use Spatie\Permission\Traits\HasRoles;

class Activity extends ModelsActivity
{
    use HasFactory, HasRoles;
}

<?php

namespace App\Policies;

use App\Models\Admin;

class ActivityPolicy
{
    /**
     * Determine whether the log-activity can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('log.*') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the log-activity can view the model.
     */
    public function view(Admin $admin): bool
    {
        return $admin->can('log.view') || $admin->hasPermissionTo('*');
    }
}

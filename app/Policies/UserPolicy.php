<?php

namespace App\Policies;

use App\Models\Admin;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('user.*') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin): bool
    {
        return $admin->can('user.view') || $admin->hasPermissionTo('*');
    }
}

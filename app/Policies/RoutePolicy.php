<?php

namespace App\Policies;

use App\Models\Admin;

class RoutePolicy
{
    /**
     * Determine whether the routes can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('routes.*') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the routes can view the model.
     */
    public function view(Admin $admin): bool
    {
        return $admin->can('routes.view') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the routes can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('routes.create') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the routes can update the model.
     */
    public function update(Admin $admin): bool
    {
        return $admin->can('routes.update') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the routes can delete the model.
     */
    public function delete(Admin $admin): bool
    {
        return $admin->can('routes.delete') || $admin->hasPermissionTo('*');
    }
}

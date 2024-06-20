<?php

namespace App\Policies;

use App\Models\Admin;

class RolePolicy
{
    /**
     * Determine whether the role can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('role.*') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the role can view the model.
     */
    public function view(Admin $admin): bool
    {
        return $admin->can('role.view') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the role can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('role.create') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the role can update the model.
     */
    public function update(Admin $admin): bool
    {
        return $admin->can('role.update') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the role can delete the model.
     */
    public function delete(Admin $admin): bool
    {
        return $admin->can('role.delete') || $admin->hasPermissionTo('*');
    }
}

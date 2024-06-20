<?php

namespace App\Policies;

use App\Models\Admin;

class PermissionPolicy
{
    /**
     * Determine whether the permission can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('permission.*') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the permission can view the model.
     */
    public function view(Admin $admin): bool
    {
        return $admin->can('permission.view') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the permission can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('permission.create') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the permission can update the model.
     */
    public function update(Admin $admin): bool
    {
        return $admin->can('permission.update') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the permission can delete the model.
     */
    public function delete(Admin $admin): bool
    {
        return $admin->can('permission.delete') || $admin->hasPermissionTo('*');
    }
}

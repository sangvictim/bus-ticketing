<?php

namespace App\Policies;

use App\Models\Admin;

class AdminPolicy
{
    /**
     * Determine whether the admin can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('admin.*') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view(Admin $admin): bool
    {
        return $admin->can('admin.view') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('admin.create') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin): bool
    {
        return $admin->can('admin.update') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin): bool
    {
        return $admin->can('admin.delete') || $admin->hasPermissionTo('*');
    }
}

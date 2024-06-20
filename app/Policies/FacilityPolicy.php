<?php

namespace App\Policies;

use App\Models\Admin;

class FacilityPolicy
{
    /**
     * Determine whether the facility can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('facility.*') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the facility can view the model.
     */
    public function view(Admin $admin): bool
    {
        return $admin->can('facility.view') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the facility can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('facility.create') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the facility can update the model.
     */
    public function update(Admin $admin): bool
    {
        return $admin->can('facility.update') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the facility can delete the model.
     */
    public function delete(Admin $admin): bool
    {
        return $admin->can('facility.delete') || $admin->hasPermissionTo('*');
    }
}

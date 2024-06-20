<?php

namespace App\Policies;

use App\Models\Admin;

class ArmadaPolicy
{
    /**
     * Determine whether the armada can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('armada.*') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the armada can view the model.
     */
    public function view(Admin $admin): bool
    {
        return $admin->can('armada.view') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the armada can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('armada.create') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the armada can update the model.
     */
    public function update(Admin $admin): bool
    {
        return $admin->can('armada.update') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the armada can delete the model.
     */
    public function delete(Admin $admin): bool
    {
        return $admin->can('armada.delete') || $admin->hasPermissionTo('*');
    }
}

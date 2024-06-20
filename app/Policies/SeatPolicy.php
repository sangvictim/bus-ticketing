<?php

namespace App\Policies;

use App\Models\Admin;

class SeatPolicy
{
    /**
     * Determine whether the seat can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('seat.*') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the seat can view the model.
     */
    public function view(Admin $admin): bool
    {
        return $admin->can('seat.view') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the seat can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('seat.create') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the seat can update the model.
     */
    public function update(Admin $admin): bool
    {
        return $admin->can('seat.update') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the seat can delete the model.
     */
    public function delete(Admin $admin): bool
    {
        return $admin->can('seat.delete') || $admin->hasPermissionTo('*');
    }
}

<?php

namespace App\Policies;

use App\Models\Admin;

class CityPolicy
{
    /**
     * Determine whether the city can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('city.*') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the city can view the model.
     */
    public function view(Admin $admin): bool
    {
        return $admin->can('city.view') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the city can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('city.create') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the city can update the model.
     */
    public function update(Admin $admin): bool
    {
        return $admin->can('city.update') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the city can delete the model.
     */
    public function delete(Admin $admin): bool
    {
        return $admin->can('city.delete') || $admin->hasPermissionTo('*');
    }
}

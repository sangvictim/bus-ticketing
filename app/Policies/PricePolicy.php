<?php

namespace App\Policies;

use App\Models\Admin;

class PricePolicy
{
    /**
     * Determine whether the price can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('price.*') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the price can view the model.
     */
    public function view(Admin $admin): bool
    {
        return $admin->can('price.view') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the price can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('price.create') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the price can update the model.
     */
    public function update(Admin $admin): bool
    {
        return $admin->can('price.update') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the price can delete the model.
     */
    public function delete(Admin $admin): bool
    {
        return $admin->can('price.delete') || $admin->hasPermissionTo('*');
    }
}

<?php

namespace App\Policies;

use App\Models\Admin;

class ClassesPolicy
{
    /**
     * Determine whether the class armada can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('class-armada.*') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the class armada can view the model.
     */
    public function view(Admin $admin): bool
    {
        return $admin->can('class-armada.view') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the class armada can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('class-armada.create') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the class armada can update the model.
     */
    public function update(Admin $admin): bool
    {
        return $admin->can('class-armada.update') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the class armada can delete the model.
     */
    public function delete(Admin $admin): bool
    {
        return $admin->can('class-armada.delete') || $admin->hasPermissionTo('*');
    }
}

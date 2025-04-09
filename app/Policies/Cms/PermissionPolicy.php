<?php

namespace App\Policies\Cms;

use App\Models\Cms\Admin;
use Illuminate\Auth\Access\Response;

class PermissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): Response|bool
    {
        return $admin->can('*') || $admin->can('permission.*');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin): Response|bool
    {
        return $admin->can('*') || $admin->can('permission.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): Response|bool
    {
        return $admin->can('*') || $admin->can('permission.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin): Response|bool
    {
        return $admin->can('*') || $admin->can('permission.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin): Response|bool
    {
        return $admin->can('*') || $admin->can('permission.delete');
    }
}

<?php

namespace App\Policies;

use App\Models\Admin;

class AgentPolicy
{
    /**
     * Determine whether the agent can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('agent.*') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the agent can view the model.
     */
    public function view(Admin $admin): bool
    {
        return $admin->can('agent.view') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the agent can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('agent.create') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the agent can update the model.
     */
    public function update(Admin $admin): bool
    {
        return $admin->can('agent.update') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the agent can delete the model.
     */
    public function delete(Admin $admin): bool
    {
        return $admin->can('agent.delete') || $admin->hasPermissionTo('*');
    }
}

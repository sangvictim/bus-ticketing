<?php

namespace App\Policies;

use App\Models\Admin;

class SchedulePolicy
{
    /**
     * Determine whether the schedule can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('schedule.*') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the schedule can view the model.
     */
    public function view(Admin $admin): bool
    {
        return $admin->can('schedule.view') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the schedule can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('schedule.create') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the schedule can update the model.
     */
    public function update(Admin $admin): bool
    {
        return $admin->can('schedule.update') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the schedule can delete the model.
     */
    public function delete(Admin $admin): bool
    {
        return $admin->can('schedule.delete') || $admin->hasPermissionTo('*');
    }
}

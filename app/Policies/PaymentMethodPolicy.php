<?php

namespace App\Policies;

use App\Models\Admin;

class PaymentMethodPolicy
{
    /**
     * Determine whether the payment gateway can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('payment-method.*') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the payment gateway can view the model.
     */
    public function view(Admin $admin): bool
    {
        return $admin->can('payment-method.view') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the payment gateway can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('payment-method.create') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the payment gateway can update the model.
     */
    public function update(Admin $admin): bool
    {
        return $admin->can('payment-method.update') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the payment gateway can delete the model.
     */
    public function delete(Admin $admin): bool
    {
        return $admin->can('payment-method.delete') || $admin->hasPermissionTo('*');
    }
}

<?php

namespace App\Policies;

use App\Models\Admin;

class TransactionPolicy
{
    /**
     * Determine whether the transaction can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('transaction.*') || $admin->hasPermissionTo('*');
    }

    /**
     * Determine whether the transaction can view the model.
     */
    public function view(Admin $admin): bool
    {
        return $admin->can('transaction.view') || $admin->hasPermissionTo('*');
    }
}

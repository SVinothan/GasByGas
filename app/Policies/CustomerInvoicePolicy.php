<?php

namespace App\Policies;

use App\Models\CustomerInvoice;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomerInvoicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('ViewAny_CustomerInvoice');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CustomerInvoice $customerInvoice): bool
    {
        return $user->hasPermissionTo('View_CustomerInvoice');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create_CustomerInvoice');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CustomerInvoice $customerInvoice): bool
    {
        return $user->hasPermissionTo('Update_CustomerInvoice');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CustomerInvoice $customerInvoice): bool
    {
        return $user->hasPermissionTo('Delete_CustomerInvoice');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CustomerInvoice $customerInvoice): bool
    {
        return $user->hasPermissionTo('Restore_CustomerInvoice');
    }

}

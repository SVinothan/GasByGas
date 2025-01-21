<?php

namespace App\Policies;

use App\Models\CustomerInvoiceItem;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomerInvoiceItemPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('ViewAny_CustomerInvoiceItem');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CustomerInvoiceItem $customerInvoiceItem): bool
    {
        return $user->hasPermissionTo('View_CustomerInvoiceItem');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create_CustomerInvoiceItem');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CustomerInvoiceItem $customerInvoiceItem): bool
    {
        return $user->hasPermissionTo('Update_CustomerInvoiceItem');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CustomerInvoiceItem $customerInvoiceItem): bool
    {
        return $user->hasPermissionTo('Delete_CustomerInvoiceItem');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CustomerInvoiceItem $customerInvoiceItem): bool
    {
        return $user->hasPermissionTo('Restore_CustomerInvoiceItem');
    }

}

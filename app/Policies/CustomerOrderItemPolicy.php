<?php

namespace App\Policies;

use App\Models\CustomerOrderItem;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomerOrderItemPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('ViewAny_CustomerOrderItem');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CustomerOrderItem $customerOrderItem): bool
    {
        return $user->hasPermissionTo('View_CustomerOrderItem');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create_CustomerOrderItem');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CustomerOrderItem $customerOrderItem): bool
    {
        return $user->hasPermissionTo('Update_CustomerOrderItem');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CustomerOrderItem $customerOrderItem): bool
    {
        return $user->hasPermissionTo('Delete_CustomerOrderItem');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CustomerOrderItem $customerOrderItem): bool
    {
        return $user->hasPermissionTo('Restore_CustomerOrderItem');
    }
 
}

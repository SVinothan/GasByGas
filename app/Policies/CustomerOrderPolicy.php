<?php

namespace App\Policies;

use App\Models\CustomerOrder;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomerOrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('ViewAny_CustomerOrder');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CustomerOrder $customerOrder): bool
    {
        return $user->hasPermissionTo('View_CustomerOrder');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create_CustomerOrder');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CustomerOrder $customerOrder): bool
    {
        return $user->hasPermissionTo('Update_CustomerOrder');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CustomerOrder $customerOrder): bool
    {
        return $user->hasPermissionTo('Delete_CustomerOrder');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CustomerOrder $customerOrder): bool
    {
        return $user->hasPermissionTo('Restore_CustomerOrder');
    }
 
}

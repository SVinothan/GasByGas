<?php

namespace App\Policies;

use App\Models\Stock;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StockPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('ViewAny_Stock');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Stock $stock): bool
    {
        return $user->hasPermissionTo('View_Stock');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create_Stock');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Stock $stock): bool
    {
        return $user->hasPermissionTo('Update_Stock');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Stock $stock): bool
    {
        return $user->hasPermissionTo('Delete_Stock');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Stock $stock): bool
    {
        return $user->hasPermissionTo('Restore_Stock');
    }
 
}

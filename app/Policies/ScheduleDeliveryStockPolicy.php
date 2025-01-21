<?php

namespace App\Policies;

use App\Models\ScheduleDeliveryStock;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ScheduleDeliveryStockPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('ViewAny_ScheduleDeliveryStock');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ScheduleDeliveryStock $scheduleDeliveryStock): bool
    {
        return $user->hasPermissionTo('View_ScheduleDeliveryStock');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create_ScheduleDeliveryStock');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ScheduleDeliveryStock $scheduleDeliveryStock): bool
    {
        return $user->hasPermissionTo('Update_ScheduleDeliveryStock');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ScheduleDeliveryStock $scheduleDeliveryStock): bool
    {
        return $user->hasPermissionTo('Delete_ScheduleDeliveryStock');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ScheduleDeliveryStock $scheduleDeliveryStock): bool
    {
        return $user->hasPermissionTo('Restore_ScheduleDeliveryStock');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ScheduleDeliveryStock $scheduleDeliveryStock): bool
    {
        //
    }
}

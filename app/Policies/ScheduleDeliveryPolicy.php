<?php

namespace App\Policies;

use App\Models\ScheduleDelivery;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ScheduleDeliveryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('ViewAny_ScheduleDelivery');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ScheduleDelivery $scheduleDelivery): bool
    {
        return $user->hasPermissionTo('View_ScheduleDelivery');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create_ScheduleDelivery');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ScheduleDelivery $scheduleDelivery): bool
    {
        return $user->hasPermissionTo('Update_ScheduleDelivery');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ScheduleDelivery $scheduleDelivery): bool
    {
        return $user->hasPermissionTo('Delete_ScheduleDelivery');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ScheduleDelivery $scheduleDelivery): bool
    {
        return $user->hasPermissionTo('Restore_ScheduleDelivery');
    }
 
}

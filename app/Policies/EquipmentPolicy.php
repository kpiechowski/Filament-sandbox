<?php

namespace App\Policies;

use App\Models\Equipment;
use App\Models\User;
use App\UserStatus;
use Illuminate\Auth\Access\Response;

class EquipmentPolicy
{

    // public function before(User $user, string $ability): bool|null
    // {
    //     if ($user->status == UserStatus::ADMIN) {
    //         return true;
    //     }
    
    //     return null;
    // }

    /**
     * Determine whether the user can view any models.
     * 
     * 
     */
    public function viewAny(User $user): bool
    {
        //
        return true;
    }
    
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Equipment $equipment): bool
    {
        //
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        $allowedStatuses = collect([
            UserStatus::ADMIN->value,
            // UserStatus::WORKER->value,
        ]);

        return $allowedStatuses->contains($user->status);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Equipment $equipment): bool
    {
        $allowedStatuses = collect([
            UserStatus::ADMIN->value,
            UserStatus::WORKER->value,
        ]);

        return $allowedStatuses->contains($user->status);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Equipment $equipment): bool
    {
        //
        $allowedStatuses = collect([
            UserStatus::ADMIN->value,
        ]);

        return $allowedStatuses->contains($user->status);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Equipment $equipment): bool
    {
        //
        $allowedStatuses = collect([
            UserStatus::ADMIN->value,
        ]);

        return $allowedStatuses->contains($user->status);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Equipment $equipment): bool
    {
        //
        $allowedStatuses = collect([
            UserStatus::ADMIN,
        ]);

        return $allowedStatuses->contains($user->status);
    }
}

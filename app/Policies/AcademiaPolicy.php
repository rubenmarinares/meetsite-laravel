<?php

namespace App\Policies;

use App\Models\Academia;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AcademiaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {           
        // This method is called when checking if the user can view any models. 
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Academia $academia): bool
    {
        
        echo "view    ";dd();
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->hasRole('admin')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Academia $academia): bool
    {

        
        if($user->hasRole('super-admin')){
            return true;
        }     
        // Verifica en la base de datos si user está relacionado con esa academia
        return $user->academiasRelation()->where('academias.id', $academia->id)->exists();     
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Academia $academia): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Academia $academia): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Academia $academia): bool
    {
        return false;
    }
}

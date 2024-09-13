<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Users;
use Illuminate\Auth\Access\Response;

class UsersPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $authUser)
    {
        return $authUser->account_type==='admin';
    }

    /**
     * Determine whether the user can view the model.
     */

    /**
     * Determine whether the user can create models.
     */
    public function create(User $authUser)
    {
        return $authUser->account_type==='admin';
    }

    /**
     * Determine whether the user can update the model.
     */

}

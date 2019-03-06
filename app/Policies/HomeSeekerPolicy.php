<?php

namespace App\Policies;

use App\User;
use App\Seekads;
use Illuminate\Auth\Access\HandlesAuthorization;

class HomeSeekerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the seekads.
     *
     * @param  \App\User  $user
     * @param  \App\Seekads  $seekads
     * @return mixed
     */
    public function view(User $user, Seekads $seekads) {
        return true;
    }

    /**
     * Determine whether the user can create seekads.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user) {
        return $user -> userType == 2;
    }

    /**
     * Determine whether the user can update the seekads.
     *
     * @param  \App\User  $user
     * @param  \App\Seekads  $seekads
     * @return mixed
     */
    public function update(User $user, Seekads $seekads) {
        return $seekads -> userFk == $user -> id;
    }

    /**
     * Determine whether the user can delete the seekads.
     *
     * @param  \App\User  $user
     * @param  \App\Seekads  $seekads
     * @return mixed
     */
    public function delete(User $user, Seekads $seekads) {
        return $seekads -> userFk == $user -> id;
    }
}

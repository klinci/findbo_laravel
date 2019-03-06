<?php

namespace App\Policies;

use App\User;
use App\Properties;
use Illuminate\Auth\Access\HandlesAuthorization;

class PropertyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the properties.
     *
     * @param  \App\User  $user
     * @param  \App\Properties  $properties
     * @return mixed
     */
    public function view(User $user, Properties $properties)
    {
        //
    }

    /**
     * Determine whether the user can create properties.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the properties.
     *
     * @param  \App\User  $user
     * @param  \App\Properties  $properties
     * @return mixed
     */
    public function update(User $user, Properties $properties)
    {
        //
    }

    /**
     * Determine whether the user can delete the properties.
     *
     * @param  \App\User  $user
     * @param  \App\Properties  $properties
     * @return mixed
     */
    public function delete(User $user, Properties $properties)
    {
        //
    }
}

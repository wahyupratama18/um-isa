<?php

namespace App\Policies;

use App\Models\Ballot;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BallotPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ballot  $ballot
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Ballot $ballot)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user): bool
    {
        return $user->isCommittee();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ballot  $ballot
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Ballot $ballot): bool
    {
        return /* $user->isCommittee()
        ? $ballot->user_id === $user->id
        :  */$user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ballot  $ballot
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Ballot $ballot): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ballot  $ballot
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Ballot $ballot)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ballot  $ballot
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Ballot $ballot)
    {
        //
    }
}

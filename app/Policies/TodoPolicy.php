<?php

namespace App\Policies;

use App\User;
use App\Todo;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Todo $todo)
    {
        return $user->id == $todo->user_id;
    }

    public function delete(User $user, Todo $todo)
    {
        return $user->id == $todo->user_id;
    }
}

<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;


    public function update(User $currentUser,User $user)
    {
        return $currentUser->id === $user -> id;
    }
    public function destroy(User $currentUser,User $user)
    {
        return $currentUser->is_admin && $currentUser->id !==$user->id;
    }

    //用户自己不能关注自己,currentuser(当前用户)
    public function follow(User $currentUser,User $user)
    {
        return $currentUser->id !==$user->id;
    }
}

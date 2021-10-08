<?php

namespace App\Policies;

use App\Models\Status;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatusPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *创造destroy函数，检查当前用户是否是作者本人
     *
     */
    public function destroy(User $user,Status $status)
    {
        return $user->id === $status->user_id;
    }
}

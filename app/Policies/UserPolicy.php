<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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


    //只能更新自己的信息
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }


    //只有管理员能删除，并且管理员不能删除自己
    public function destroy(User $currentUser, User $user)
    {
        $currentUser->is_admin && $currentUser->id !== $user->id;
    }

    //自己不能关注自己
    public function follows(User $currentUser, User $user)
    {
        return $currentUser->id != $user->id;
    }







}

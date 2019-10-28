<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowersController extends Controller
{
    public function __construct()
    {
        //过滤未登录的请求
        $this->middleware('auth');
    }


    //关注用户
    public function store(User $user)
    {
        //授权判断
        $this->authorize('follows', $user);

        if(!Auth::user()->isfollowing($user->id)){
            Auth::user()->follow($user->id);
        }

        return redirect()->route('users.show', $user);
    }



    //取消关注
    public function destroy(User $user)
    {
        //授权判断
        $this->authorize('follows', $user);

        if(Auth::user()->isfollowing($user->id)){
            Auth::user()->unfollow($user->id);
        }

        return redirect()->route('users.show', $user);
    }


}


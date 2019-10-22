<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * 注册页面
     */
    public function create()
    {
        return view('users.create');
    }


    /**
     * 注册逻辑
     */
    public function store()
    {
        


    }


    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 个人信息页
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
}

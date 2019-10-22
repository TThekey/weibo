<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
    public function store(Request $request)
    {
        //验证
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        //用户信息存储到数据库
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);


        //注册成功，自动登录
        Auth::login($user);

        //消息提示
        session()->flash('success', '您即将开启一段新旅程');

        //重定向
        return redirect()->route('users.show',[$user]);
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

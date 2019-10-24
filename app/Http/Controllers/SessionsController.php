<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        //只让未登录用户访问登录页面
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }


    /**
     * 登录界面
     */
    public function create()
    {
        return view('sessions.create');
    }


    /**
     * 登录逻辑处理
     */
    public function store(Request $request)
    {
        //验证字段
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        //进行身份认证
        if(Auth::attempt($credentials, $request->has('remember'))){
            session()->flash('success', '欢迎回来');

            //重定向到上一次请求访问的页面
            $fallback = route('users.show', [Auth::user()]);
            return redirect()->intended($fallback);
        }else{
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
    }


    /**
     * 退出登录
     */
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出');
        return redirect('login');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    public function __construct()
    {
        //auth中间件来过滤未登录用户
        $this->middleware('auth', [
            'except' => ['create', 'show', 'store','index','confirmEmail']
        ]);

        //只让未登录用户访问注册界面
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 用户列表页面
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 注册页面
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
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


        //注册成功，发送激活邮箱
        $this->sendEmailConfirmationTo($user);

        //消息提示
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收');

        //重定向
        return redirect('/');
    }


    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 个人信息页面
     */
    public function show(User $user)
    {
        $statuses = $user->statuses()
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);
        return view('users.show', compact('user', 'statuses'));
    }


    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 更新信息页面
     */
    public function edit(User $user)
    {
        //使用自定义的授权策略
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    /**
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     * 更新信息逻辑
     */
    public function update(User $user, Request $request)
    {
        //使用自定义的授权策略
        $this->authorize('update', $user);
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);


        $data = [];
        $data['name'] = $request->name;

        if($request->password){
            $data['password'] = $request->password;
        }

        $user->update($data);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', [$user]);
    }


    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * 删除用户
     */
    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);

        $user->delete();

        session()->flash('success', '成功删除用户!');

        return back();
    }


    /**
     * @param $user
     * 发送注册激活邮件
     */
    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'tthekey1997@163.com';
        $name = 'TThekey';
        $to = $user->email;
        $subject = "感谢注册 Weibo 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }


    /**
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     * 激活注册用户逻辑
     */
    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', [$user]);
    }


    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 我的关注列表
     */
    public function followings(User $user)
    {
        $users = $user->followings()->paginate(30);
        $title = $user->name . '的关注';
        return view('users.show_follow', compact('users', 'title'));
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 我的粉丝列表
     */
    public function followers(User $user)
    {
        $users = $user->followers()->paginate(30);
        $title = $user->name . '的粉丝';
        return view('users.show_follow', compact('users', 'title'));
    }











}

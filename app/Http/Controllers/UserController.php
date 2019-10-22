<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * 注册
     */
    public function create()
    {
        return view('users.create');
    }
}

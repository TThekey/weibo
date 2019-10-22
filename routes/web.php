<?php

use \Illuminate\Support\Facades\Route;

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

//注册界面
Route::get('signup', 'UserController@create')->name('signup');


//用户资源路由
Route::resource('users', 'UserController');

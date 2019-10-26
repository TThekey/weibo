<?php

use \Illuminate\Support\Facades\Route;

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

//注册界面
Route::get('signup', 'UserController@create')->name('signup');


//用户资源路由
Route::resource('users', 'UserController');


//会话(登录)
Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');


//邮件激活
Route::get('signup/confirm/{token}', 'UserController@confirmEmail')->name('confirm_email');


//重设密码
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');


//微博的创建和删除
Route::resource('statuses', 'StatusesController', ['only' => ['store', 'destroy']]);




<?php

Route::get('/', 'StaticPagesController@home')->home('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');




<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function ()
{
	return view('welcome');
});

Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/threads', 'ThreadsController@index')->name('threads.index');
Route::get('/threads/{thread}', 'ThreadsController@show')->name('threads.show');

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function ()
{
	return view('welcome');
});

Route::get('test', function ()
{
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/threads', 'ThreadsController@index')->name('threads.index');
Route::get('/threads/{thread}', 'ThreadsController@show')->name('threads.show');
Route::post('/threads/{thread}/replies', 'RepliesController@store');

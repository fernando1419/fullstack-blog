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
// Route::get('/threads', 'ThreadsController@index')->name('threads.index');
// Route::get('/threads/create', 'ThreadsController@create')->name('threads.create');
// Route::post('/threads', 'ThreadsController@store')->name('threads.store');
// Route::get('/threads/{thread}', 'ThreadsController@show')->name('threads.show');
Route::resource('threads', 'ThreadsController');
Route::post('/threads/{thread}/replies', 'RepliesController@store');

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', function() { return view('home'); } );

Route::post('/threads/{channel}/{thread}/replies', 'ReplyController@store');

//Route::resource('threads', 'ThreadController');
Route::get('threads', 'ThreadController@index');
Route::get('threads/create', 'ThreadController@create');
Route::get('threads/{channel}', 'ThreadController@index');
Route::get('threads/{channel}/{thread}', 'ThreadController@show');
Route::delete('threads/{channel}/{thread}', 'ThreadController@destroy');
Route::post('threads', 'ThreadController@store');
Route::post('replies/{reply}/favourite', 'FavouriteController@store');

Route::get('/users/{user}', 'ProfileController@show')->name('profile');
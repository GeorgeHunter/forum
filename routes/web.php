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

/*
 * Base routes
 *
 * Set an entry point by redirecting / to threads, persist home so we don't have to change up basic auth
 * */

Route::get('/', function () { return redirect('/threads'); });
Route::get('/home', function() { return view('home'); } );


/*
 * Threads Routes
 *
 * Creating/updating and retrieving threads. At this point these do most of the UI creating heavy lifting
 * */

Route::get('threads', 'ThreadController@index');
Route::get('threads/create', 'ThreadController@create');
Route::get('threads/{channel}', 'ThreadController@index');
Route::get('threads/{channel}/{thread}', 'ThreadController@show');
Route::delete('threads/{channel}/{thread}', 'ThreadController@destroy');
Route::post('threads', 'ThreadController@store');


/*
 * Replies Routes
 *
 * Used for creating/updating Replies themselves, not accessing the data
 *
 */

Route::delete('replies/{reply}', 'ReplyController@destroy');
Route::patch('replies/{reply}', 'ReplyController@update');
Route::post('/threads/{channel}/{thread}/replies', 'ReplyController@store');
Route::post('replies/{reply}/favourite', 'FavouriteController@store');
Route::delete('replies/{reply}/favourite', 'FavouriteController@destroy');


/*
 * User routes
 *
 * Accessing profiles
 *
 */

Route::get('/users/{user}', 'ProfileController@show')->name('profile');
Auth::routes();
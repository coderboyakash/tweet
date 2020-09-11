<?php

use Illuminate\Support\Facades\Route;
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
use App\Tweet;
Route::get('/', function () {
    $tweets = Tweet::orderBy('created_at', 'DESC')->get();
    return view('welcome', compact('tweets'));
})->name('welcome');

Auth::routes();
Route::resource('tweet', 'TweetsController');
Route::resource('user', 'UsersController');
Route::get('/home', 'UsersController@index')->name('home');
Route::get('/followings', 'UsersController@followings')->name('followings');
Route::get('/user/follow/{id}', 'UsersController@follow')->name('user.follow');
Route::get('/user/unfollow/{id}', 'UsersController@unfollow')->name('user.unfollow');
Route::post('search', 'TweetsController@search')->name('search');
Route::get('user/{user}', 'TweetsController@getUserProfile')->name('user.show');
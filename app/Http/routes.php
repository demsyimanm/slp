<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/', 'HomeController@login');
Route::post('/', 'HomeController@login');
Route::get('mboh', 'HomeController@coba');
Route::post('register', 'HomeController@daftar');

Route::group(['middleware' => 'auth'], function()
{
	Route::get('logout', 'HomeController@logout');
});
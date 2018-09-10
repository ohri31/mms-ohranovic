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

// Redirect
Route::get('/', 'SongsController@redirect');

// Resource for the songs controlelr
Route::resource('songs', 'SongsController');

// List all songs in a JSON format
Route::get('songs/all/json', 'SongsController@listAll');

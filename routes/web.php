<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DBUserController;

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
    return abort(404);
});

Route::get('users/final-submit', 'App\Http\Controllers\UserController@finalSubmit')->name('users.final-submit');
Route::resource('users', UserController::class);


Route::get('dbusers/export', 'App\Http\Controllers\DBUserController@export')->name('dbusers.export');
Route::get('dbusers/import', 'App\Http\Controllers\DBUserController@import')->name('dbusers.import');
Route::resource('dbusers', DBUserController::class);

// Fallback for not exist routes
Route::fallback(function () {
    return abort(404);
});
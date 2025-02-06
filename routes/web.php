<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('users/export', 'App\Http\Controllers\UserController@export')->name('users.export');
Route::resource('users', UserController::class);

// Fallback for not exist routes
Route::fallback(function () {
    return abort(404);
});
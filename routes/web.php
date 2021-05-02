<?php

use App\Http\Controllers\LoginController;
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

Route::get('/', function () {
    return view('dashboard');
})->name("dashboard");

Route::get('/login', "App\Http\Controllers\LoginController@index")->name("login");
Route::post('/login', "App\Http\Controllers\LoginController@store");

Route::get('/register', "App\Http\Controllers\RegisterController@index")->name("register");
Route::post('/register', "App\Http\Controllers\RegisterController@store");
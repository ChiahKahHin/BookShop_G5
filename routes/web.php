<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
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

Route::get('/login', [LoginController::class, "index"])->name("login");
Route::post('/login', [LoginController::class, "store"]);
Route::get('/logout', [LogoutController::class, "index"])->name("logout");
Route::get('/addAdmin', [UserController::class, 'index'])->name('addAdmin');
Route::post('/addAdmin', [UserController::class, 'store']);
Route::get('/manageAdmin', [UserController::class, 'manageAdmin'])->name('manageAdmin');
Route::get('/manageAdmin/{id}', [UserController::class, 'deleteAdmin']);

Route::get('/addStock', [StockController::class, 'index'])->name('addStock');
Route::post('/addStock', [StockController::class, 'store']);

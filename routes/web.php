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

Route::get('/login', [LoginController::class, "index"])->name("login");
Route::post('/login', [LoginController::class, "store"]);
Route::get('/logout', [LogoutController::class, "index"])->name("logout");
Route::get('/addAdmin', [UserController::class, 'index'])->name('addAdmin');
Route::post('/addAdmin', [UserController::class, 'store']);
Route::get('/editStock/{isbn}', [StockController::class, 'editStockForm'])->name('editStock');
Route::post('/editStock/{isbn}', [StockController::class, 'editStock']);
Route::get('/editAdmin/{id}', [UserController::class, 'editAdmin'])->name('editAdmin');
Route::post('/editAdmin/{id}', [UserController::class, 'updateAdmin']);
Route::get('/viewAdmin/{id}', [UserController::class, 'viewAdmin'])->name('viewAdmin');
Route::get('/manageAdmin', [UserController::class, 'manageAdmin'])->name('manageAdmin');
Route::get('/manageAdmin/{id}', [UserController::class, 'deleteAdmin']);
Route::get('/changePassword', [UserController::class, 'changePasswordForm'])->name("changePassword");
Route::post('/changePassword', [UserController::class, 'changePassword']);

Route::get('/addStock', [StockController::class, 'addStockForm'])->name('addStock');
Route::post('/addStock', [StockController::class, 'store']);

Route::get('/viewAccount', [UserController::class, 'viewAccount'])->name("viewAccount");
Route::get('/editAccount', [UserController::class, 'editAccount'])->name("editAccount");
Route::post('/editAccount', [UserController::class, 'updateAccount'])->name("updateAccount");

Route::get('/', [StockController::class, 'homepage'])->name("home");
Route::get('/dashboard', [StockController::class, 'index'])->name("dashboard");
Route::get('/stock/{isbn}', [StockController::class, 'bookDetails'])->name("stockDetails");
Route::get('/dashboard/delete/{isbn}', [StockController::class, 'delete']);
Route::get('/stock/delete/{isbn}', [StockController::class, 'deleteStock']);
Route::post('/search', [StockController::class, 'homepageSearch'])->name("homeSearch");

Route::get('/customerRegistration', [UserController::class, 'customerRegistration'])->name("customerRegistration");
Route::post('/customerRegistration', [UserController::class, 'addCustomer'])->name("addCustomer");

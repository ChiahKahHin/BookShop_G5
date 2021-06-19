<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\StateController;
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

Route::get('/customerRegistration', [RegisterController::class, 'customerRegistration'])->name("customerRegistration");
Route::post('/customerRegistration', [RegisterController::class, 'addCustomer']);

Route::get('/forgetPassword', [ForgetPasswordController::class, 'index'])->name("forgotPassword");
Route::post('/forgetPassword', [ForgetPasswordController::class, 'notifyEmail']);
Route::get('/forgetPassword/{token}', [ForgetPasswordController::class, 'resetPassword'])->name('password.reset');
Route::post('/forgetPassword/{token}', [ForgetPasswordController::class, 'changePassword']);

Route::get('/changePassword', [UserController::class, 'changePasswordForm'])->name("changePassword");
Route::post('/changePassword', [UserController::class, 'changePassword']);

Route::get('/logout', [LogoutController::class, "index"])->name("logout");

Route::get('/addAdmin', [UserController::class, 'index'])->name('addAdmin');
Route::post('/addAdmin', [UserController::class, 'store']);
Route::get('/manageAdmin', [UserController::class, 'manageAdmin'])->name('manageAdmin');
Route::get('/manageAdmin/{id}', [UserController::class, 'deleteAdmin']);
Route::get('/editAdmin/{id}', [UserController::class, 'editAdmin'])->name('editAdmin');
Route::post('/editAdmin/{id}', [UserController::class, 'updateAdmin']);
Route::get('/editAccount', [UserController::class, 'editAccount'])->name("editAccount");
Route::post('/editAccount', [UserController::class, 'updateAccount']);
Route::get('/viewAdmin/{id}', [UserController::class, 'viewAdmin'])->name('viewAdmin');
Route::get('/viewAccount', [UserController::class, 'viewAccount'])->name("viewAccount");
Route::get('/reloadWallet', [UserController::class, 'reloadWalletForm'])->name("reloadWallet");
Route::post('/reloadWallet', [UserController::class, 'reloadWallet']);

Route::get('/', [StockController::class, 'homepage'])->name("home");
Route::get('/dashboard', [StockController::class, 'index'])->name("dashboard");
Route::get('/stock/{isbn}', [StockController::class, 'bookDetails'])->name("stockDetails");
Route::get('/dashboard/delete/{isbn}', [StockController::class, 'delete']);
Route::get('/stock/delete/{isbn}', [StockController::class, 'deleteStock']);
Route::post('/search', [StockController::class, 'homepageSearch'])->name("homeSearch");
Route::post('/addToCart', [StockController::class, 'addToCart'])->name("addToCart");
Route::get('/cart', [StockController::class, 'showCart'])->name("cart");
Route::get('/cart/deleteCartItem/{id}', [StockController::class, 'deleteCartItem']);
Route::get('/addStock', [StockController::class, 'addStockForm'])->name('addStock');
Route::post('/addStock', [StockController::class, 'store']);
Route::post('/checkISBN', [StockController::class, 'checkISBN'])->name("checkISBN");
Route::get('/editStock/{isbn}', [StockController::class, 'editStockForm'])->name('editStock');
Route::post('/editStock/{isbn}', [StockController::class, 'editStock']);
Route::get('/checkout', [StockController::class, 'checkout'])->name('checkout');

Route::get('/manageState', [StateController::class, 'manageState'])->name('manageState');
Route::get('/addState', [StateController::class, 'addStateForm'])->name('addState');
Route::post('/addState', [StateController::class, 'addState']);
Route::get('/editState/{id}', [StateController::class, 'editStateForm'])->name('editState');
Route::post('/editState/{id}', [StateController::class, 'editState']);
Route::get('/state', [StateController::class, 'getState'])->name("getState");

Route::post('/comments/{isbn}', [CommentController::class, 'addComment'])->name("addcomment");
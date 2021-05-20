<?php

use App\Http\Controllers\StockController;
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

// Route::get('/home', [StockController::class, 'homepage'])->name("home");
// Route::get('/', [StockController::class, 'index'])->name("dashboard");
// Route::get('/stock/{isbn}', [StockController::class, 'bookDetails']);
// Route::get('/{isbn}', [StockController::class, 'delete']);
// Route::get('/stock/delete/{isbn}', [StockController::class, 'deleteStock']);
// Route::post('/home/search', [StockController::class, 'homepageSearch'])->name("homeSearch");

Route::get('/', [StockController::class, 'homepage'])->name("home");
Route::get('/dashboard', [StockController::class, 'index'])->name("dashboard");
Route::get('/stock/{isbn}', [StockController::class, 'bookDetails'])->name("stockDetails");
Route::get('/dashboard/delete/{isbn}', [StockController::class, 'delete']);
Route::get('/stock/delete/{isbn}', [StockController::class, 'deleteStock']);
Route::post('/search', [StockController::class, 'homepageSearch'])->name("homeSearch");
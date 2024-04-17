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

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('otp/{userId}', [App\Http\Controllers\Auth\LoginController::class, 'getOTP'])->name('otp');
Route::post('verifyotp', [App\Http\Controllers\Auth\LoginController::class, 'verifyOTP'])->name('verifyotp');
Route::post('import-product', [App\Http\Controllers\HomeController::class, 'importProduct'])->name('import-product');
Route::post('sale-item', [App\Http\Controllers\HomeController::class, 'saleItem'])->name('sale-item');

Route::post('logout',  [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');



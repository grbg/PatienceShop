<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
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

Route::get('/', [ProductController::class, 'index']);

Route::post('/registration', [UserController::class, 'userRegister'])->name('register');

Route::get('/shop', [ProductController::class, 'index']);

Route::get('/shop/man', [ProductController::class, 'getManSection']);

Route::get('/shop/woman', [ProductController::class, 'getWomanSection']);

Route::post('/shop/filter', [ProductController::class, 'filterProducts'])->name('shop.filter');

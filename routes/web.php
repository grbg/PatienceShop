<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;

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
Route::get('/login', [UserController::class, 'userLogin'])->name('login');

Route::get('/shop', [ProductController::class, 'store']);

Route::get('/shop/man', [ProductController::class, 'getManSection']);

Route::get('/shop/woman', [ProductController::class, 'getWomanSection']);

Route::post('/shop/filter', [ProductController::class, 'filterProducts'])->name('shop.filter');

Route::get('/shop/{gender}/{category}', [ProductController::class, 'filterByCategory']);

Route::get('product', [ProductController::class, 'indexProduct']);

// Route::post('product/update/{id}', [ProductController::class, 'updateProduct'])->name('product_update');

Route::post('/update-product', 'ProductController@updateProduct')->name('update.product');

Route::post('/add-product', [ProductController::class, 'addProduct'])->name('addProduct');

Route::delete('/products/{id}', [ProductController::class, 'destroy']);

Route::get('/profile', function() {
    return view('profile');
});

Route::post('/cart/add', [CartController::class, 'addProductInCart']);

Route::get('/cart/confim', function() {
    return view('cart');
});
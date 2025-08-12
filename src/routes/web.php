<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

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

Route::get('/', [ProductController::class,'index'])->name('index');
Route::get('/item/{item_id}', [ProductController::class, 'show'])->name('item.show');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'store'])->name('user.store');
Route::get('/mypage/profile', [UserController::class, 'showProfileForm'])->name('mypage.profile');
Route::post('/mypage/profile/{user_id}', [UserController::class, 'storeProfile'])->name('profile.store');
Route::get('/purchase/{item_id}', [OrderController::class, 'create'])->name('purchase.create');
Route::post('/purchase', [OrderController::class, 'store'])->name('purchase.store');
Route::get('/purchase/address/{item_id}', [OrderController::class,'createSending'])->name('purchase.address');
Route::post('/purchase/address/{item_id}', [OrderController::class,'store'])->name('sending.store');
Route::put('/mypage/profile', [UserController::class, 'profile'])->name('mypage.profile.update');
Route::get('/mypage', [UserController::class, 'show'])->name('mypage.show')->middleware('auth');
Route::get('/sell', [ProductController::class, 'create'])->name('sell');
Route::post('/items', [ProductController::class, 'store'])->name('items.store');
Route::post('/products/{product}/like', [ProductController::class, 'toggleLike'])->name('products.like')->middleware('auth');
Route::post('/items/{item}/comments', [ProductController::class, 'comment'])->name('comments.store');

Route::get('/mylist', [ProductController::class, 'myList'])->name('mylist');
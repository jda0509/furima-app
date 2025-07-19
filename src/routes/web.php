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
Route::post('/register', [UserController::class, 'store'])->name('user.store');
Route::get('/mypage/profile', [UserController::class, 'showProfileForm'])->name('mypage.profile');
Route::post('/mypage/profile', [UserController::class, 'storeProfile'])->name('profile.store');
Route::put('/mypage/profile/{user_id}', [UserController::class, 'update'])->name('profile.update');
Route::get('/purchase/{item_id}', [OrderController::class, 'create'])->name('purchase.create');
Route::post('/purchase', [OrderController::class, 'store'])->name('purchase.store');
Route::get('/purchase/address/{item_id}', [OrderController::class,'createSending'])->name('purchase.address');
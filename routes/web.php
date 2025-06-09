<?php

use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Роуты для регистрации и логина
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Выход (logout)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Роуты, доступные только для авторизованных пользователей
Route::middleware('auth')->group(function () {
    // Корзина
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

    // Профиль пользователя
    Route::get('/profile', function () {
        return view('profile'); // Позже создайте view 'profile'
    })->name('profile');
});

// Админ-панель: товары
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', CategoryController::class);
});

// Главная и просмотр товара (доступно всем)
Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/product/{id}', [SiteController::class, 'show'])->name('product.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.process');
    Route::get('/checkout/thankyou', [OrderController::class, 'thankyou'])->name('checkout.thankyou');
});

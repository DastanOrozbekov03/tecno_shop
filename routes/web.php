<?php

use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Роуты для регистрации и логина
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Выход
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Роуты, доступные только авторизованным пользователям
Route::middleware('auth')->group(function () {
    // Корзина
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    // Профиль
    Route::get('/profile', function () {
        $orders = \App\Models\Order::where('user_id', Auth::id())->with('items.product')->latest()->get();
        return view('profile', compact('orders'));
    })->name('profile');

    // Оформление заказа
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.process');
    Route::get('/checkout/thankyou', [OrderController::class, 'thankyou'])->name('checkout.thankyou');
});

// Админ-панель — роуты с префиксом admin, с middleware auth и проверкой is_admin через Closure
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::group(['middleware' => function ($request, $next) {
        if (!Auth::user() || !Auth::user()->is_admin) {
            abort(403, 'У вас нет доступа');
        }
        return $next($request);
    }], function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', AdminProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::post('/orders/{id}/received', [AdminOrderController::class, 'markReceived'])->name('orders.received');
        Route::post('/orders/{id}/paid', [AdminOrderController::class, 'markPaid'])->name('orders.paid');
        Route::post('/orders/delete-uncollected', [AdminOrderController::class, 'deleteUncollected'])->name('orders.delete-uncollected');
    });
});

// Главная страница и просмотр товара — доступны всем
Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/product/{id}', [SiteController::class, 'show'])->name('product.show');

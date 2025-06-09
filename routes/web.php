<?php

// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;

Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/product/{id}', [SiteController::class, 'show'])->name('product.show');

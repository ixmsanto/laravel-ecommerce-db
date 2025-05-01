<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EcommerceController;

Route::get('/products/high-stock', [EcommerceController::class, 'getHighStockProducts']);
Route::get('/users/{userId}/orders', [EcommerceController::class, 'getUserOrders']);
Route::post('/orders', [EcommerceController::class, 'placeOrder']);

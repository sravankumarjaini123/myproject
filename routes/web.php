<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [FrontendController::class, 'login']);
Route::get('/register', [FrontendController::class, 'register']);
Route::get('/products', [FrontendController::class, 'products']);
Route::get('/products/{id}', [FrontendController::class, 'productShow']);
Route::get('/cart', [FrontendController::class, 'cart']);
<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
// use App\Http\Controllers\Admin\AdminAuth;

// Route::post('/login', [AdminAuth::class, 'login']);
// Route::middleware('auth:sanctum')->group(function () {
    //routes for auth
    // Route::post('/logout', [AdminAuth::class, 'logout']);
    // Route::get('/profile', [AdminAuth::class, 'profile']);
    //routes for category
    Route::prefix('/admin')->group(function () {
        Route::resource('category', CategoryController::class);
        Route::patch('/changeStatus/{id}', [CategoryController::class,'changeStatus']);
    });
// });

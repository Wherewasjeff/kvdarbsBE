<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StorageController;

// Existing routes...
Route::post('/store', [StoreController::class, 'store']);
Route::get('/show/{store_id}', [StoreController::class, 'show']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/register', [RegisterController::class, 'register']);
Route::delete('/storage/{id}', [StorageController::class, 'destroy']);
Route::post('/storage', [StorageController::class, 'storage']);
Route::post('/categories', [StorageController::class, 'addCategory'])->middleware('auth:sanctum');
    Route::get('/categories', [StorageController::class, 'getCategories']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
Route::put('/show/{store_id}', [StoreController::class, 'update']);
Route::get('/user/{id}', [UserController::class, 'show'])->middleware('auth:sanctum');
Route::put('/user/{id}', [UserController::class, 'update'])->middleware('auth:sanctum'); // Assuming you don't need an ID here, just the authenticated user
Route::get('/user/{id}', function ($id) {
    dd("Route hit with id: $id");
});

Route::get('/storage', [StorageController::class, 'getStorage']); // New GET method for storage

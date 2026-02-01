<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;


// ----------------------
// User Authentication Routes
// ----------------------

// Public routes
Route::post('register', [UserController::class, 'register']); // Register a new user
Route::post('login', [UserController::class, 'login']);       // Login user and get JWT token

// Protected routes (require JWT token)
Route::middleware('auth:api')->group(function () {
    Route::get('me', [UserController::class, 'me']);       // Get current logged-in user
    Route::post('logout', [UserController::class, 'logout']); // Logout user (invalidate token)
});


Route::get('/', function () {
    return response()->json(['message' => 'API is working']);
});

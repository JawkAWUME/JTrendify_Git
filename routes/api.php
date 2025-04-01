<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Authenticated routes
// Route::middleware([EnsureFrontendRequestsAreStateful::class, 'auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {
    // Déconnexion
    Route::post('logout', [AuthController::class, 'logout']);

    // Mise à jour du profil
    Route::put('update-profile', [AuthController::class, 'updateProfile']);

    // Protection des routes par rôle (exemple: seulement pour l'admin)
    Route::middleware('role:admin')->group(function () {
        Route::post('/products', [ProductController::class, 'store']);
        Route::patch('/products/{id}/assign-category', [ProductController::class, 'assignCategory']);
        Route::put('/products/{id}', [ProductController::class, 'update']);
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    }); 

    Route::get('/products', [ProductController::class, 'index']);
    // Route::post('/products', [ProductController::class, 'store'])->middleware('admin');
    Route::get('/products/{id}', [ProductController::class, 'show']);
    // Route::patch('/products/{id}/assign-category', [ProductController::class, 'assignCategory'])->middleware('admin');
    Route::post('/products/{id}/reviews', [ReviewController::class, 'store']);
    Route::post('/products/{id}/favorite', [FavoriteController::class, 'toggleFavorite']);
    // Route::put('/products/{id}', [ProductController::class, 'update'])->middleware('admin');
    // Route::delete('/products/{id}', [ProductController::class, 'destroy'])->middleware('admin');
    
});

// Routes publiques
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login'); // Named login route
Route::post('reset-password', [AuthController::class, 'resetPassword']);

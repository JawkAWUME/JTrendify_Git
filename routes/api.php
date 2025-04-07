<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;

// Routes protégées avec Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::put('update-profile', [AuthController::class, 'updateProfile']);

    // Routes accessibles aux utilisateurs authentifiés
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::post('/products/{id}/reviews', [ReviewController::class, 'store']);
    Route::post('/products/{id}/favorite', [FavoriteController::class, 'toggleFavorite']);

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/{category}', [CategoryController::class, 'show']);
        Route::get('/{category}/products', [CategoryController::class, 'getProducts']);
        Route::get('/filter', [CategoryController::class, 'filter']);
    });

    // Routes nécessitant une autorisation spécifique (via Gates)
    Route::post('/products', [ProductController::class, 'store']);
    Route::patch('/products/{id}/assign-category', [ProductController::class, 'assignCategory']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    Route::prefix('categories')->group(function () {
        Route::post('/', [CategoryController::class, 'store']);
        Route::put('/{category}', [CategoryController::class, 'update']);
        Route::delete('/{category}', [CategoryController::class, 'destroy']);
        Route::post('/{category}/subcategories', [CategoryController::class, 'addSubcategory']);
        Route::delete('/{category}/subcategories/{subcategory}', [CategoryController::class, 'removeSubcategory']);
    });
});

// Routes publiques
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('reset-password', [AuthController::class, 'resetPassword']);

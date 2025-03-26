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
    Route::middleware('role:admin')->get('admin-dashboard', function () {
        return response()->json(['message' => 'Welcome Admin']);
    });
});

// Routes publiques
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login'); // Named login route
Route::post('reset-password', [AuthController::class, 'resetPassword']);

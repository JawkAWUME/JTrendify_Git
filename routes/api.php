<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    // Inscription
    Route::post('register', [AuthController::class, 'register']);

    // Connexion
    Route::post('login', [AuthController::class, 'login']);

    // Déconnexion (protected by auth:api middleware)
    Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);

    // Réinitialisation du mot de passe
    Route::post('reset-password', [AuthController::class, 'resetPassword']);

    // Mise à jour du profil (protected by auth:api middleware)
    Route::middleware('auth:api')->put('update-profile', [AuthController::class, 'updateProfile']);

    // Protection des routes par rôle (exemple: seulement pour l'admin)
    Route::middleware(['auth:api', 'role:admin'])->get('admin-dashboard', function () {
        return response()->json(['message' => 'Welcome Admin']);
    });
});
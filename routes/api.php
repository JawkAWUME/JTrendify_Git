<?php
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

// Inscription
Route::post('register', [AuthController::class, 'register']);

// Connexion
Route::post('login', [AuthController::class, 'login']);

// Déconnexion
Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);

// Réinitialisation du mot de passe
Route::post('reset-password', [AuthController::class, 'resetPassword']);

// Mise à jour du profil
Route::middleware('auth:api')->put('update-profile', [AuthController::class, 'updateProfile']);

// Protection des routes par rôle (exemple: seulement pour l'admin)
Route::middleware(['auth:api', 'role:admin'])->get('admin-dashboard', function () {
    return response()->json(['message' => 'Welcome Admin']);
});

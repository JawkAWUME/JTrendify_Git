<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $policies = [
        Product::class => ProductPolicy::class,
    ];

    public function boot()
    {
        Gate::define('manage-products', function ($user) {
            return in_array($user->role, ['admin', 'vendeur']);
        });

        Gate::define('is-admin', function (User $user) {
            return $user->role === 'admin';
        });
    
        // Vérifie si l'utilisateur peut créer une catégorie
        Gate::define('create-category', function (User $user) {
            return $user->role === 'admin';
        });
    
        // Vérifie si l'utilisateur peut modifier une catégorie
        Gate::define('update-category', function (User $user, Category $category) {
            return $user->role === 'admin';
        });
    
        // Vérifie si l'utilisateur peut supprimer une catégorie
        Gate::define('delete-category', function (User $user, Category $category) {
            return $user->role === 'admin';
        });
    
        // Vérifie si l'utilisateur peut gérer les sous-catégories
        Gate::define('manage-subcategories', function (User $user, Category $category) {
            return $user->role === 'admin';
        });
    }
    public function register(): void
    {
        //
    }

}

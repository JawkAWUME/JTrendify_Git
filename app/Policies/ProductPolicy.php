<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * L'utilisateur peut voir la liste des produits ?
     */
    public function viewAny(User $user): bool
    {
        return true; // Tout utilisateur peut voir la liste des produits
    }

    /**
     * L'utilisateur peut voir un produit spécifique ?
     */
    public function view(User $user, Product $product): bool
    {
        return true; // Tout utilisateur peut voir un produit
    }

    /**
     * L'utilisateur peut créer un produit ?
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'vendeur']);
    }

    /**
     * L'utilisateur peut modifier un produit ?
     */
    public function update(User $user, Product $product): bool
    {
        return $user->id === $product->user_id || $user->role === 'admin';
    }

    /**
     * L'utilisateur peut supprimer un produit ?
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->id === $product->user_id || $user->role === 'admin';
    }

    /**
     * L'utilisateur peut restaurer un produit supprimé ?
     */
    public function restore(User $user, Product $product): bool
    {
        return $user->role === 'admin';
    }

    /**
     * L'utilisateur peut supprimer définitivement un produit ?
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return $user->role === 'admin';
    }

    /**
     * L'utilisateur peut assigner une catégorie à un produit ?
     */
    public function assignCategory(User $user, Product $product): bool
    {
        return $user->id === $product->user_id || $user->role === 'admin';
    }
    /**
     * L'utilisateur peut gérer les stocks d'un produit ?
     */
    public function manageStock(User $user, Product $product): bool
    {
        return $user->role === 'admin' || $user->id === $product->user_id;
    }
}

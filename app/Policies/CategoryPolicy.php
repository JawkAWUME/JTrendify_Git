<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * L'utilisateur peut voir la liste des catégories ?
     */
    public function viewAny(User $user): bool
    {
        return true; // Tout utilisateur peut voir la liste des catégories
    }

    /**
     * L'utilisateur peut voir une catégorie spécifique ?
     */
    public function view(User $user, Category $category): bool
    {
        return true; // Tout utilisateur peut voir une catégorie
    }

    /**
     * L'utilisateur peut créer une catégorie ?
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * L'utilisateur peut modifier une catégorie ?
     */
    public function update(User $user, Category $category): bool
    {
        return $user->role === 'admin';
    }

    /**
     * L'utilisateur peut supprimer une catégorie ?
     */
    public function delete(User $user, Category $category): bool
    {
        return $user->role === 'admin';
    }

    /**
     * L'utilisateur peut restaurer une catégorie supprimée ?
     */
    public function restore(User $user, Category $category): bool
    {
        return $user->role === 'admin';
    }

    /**
     * L'utilisateur peut supprimer définitivement une catégorie ?
     */
    public function forceDelete(User $user, Category $category): bool
    {
        return $user->role === 'admin';
    }

    /**
     * L'utilisateur peut gérer les sous-catégories ?
     */
    public function manageSubcategories(User $user, Category $category): bool
    {
        return $user->role === 'admin';
    }

}

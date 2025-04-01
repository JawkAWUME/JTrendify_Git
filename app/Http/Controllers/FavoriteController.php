<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggleFavorite(Product $product) {
        $user = auth()->user();
        $existingFavorite = $user->favorites()->where('product_id')->first();

        if($existingFavorite) {
            $existingFavorite->delete();
            return response()->json(['message' => 'Produit retiré des favoris']);
        } else {
            $user->favorites()->create(['product_id' => $product->id]);
            return response()->json(['message' => 'Produit ajouté aux favoris']);
        }

    }
}

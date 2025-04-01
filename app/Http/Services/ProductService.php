<?php

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductService {
    public function createProduct($data) {
        $product = Product::create($data);

        if (isset($data['image'])) {
            $product->addMedia($data['image'])->toMediaCollection('products');
        }

        return $product;
    }

    public function updateProduct($product,$data) {
        $product->update($data);

        if(isset($data['image'])) {
            $product->clearMediaCollection('products');
            $product->addMedia($data['image'])->toMediaCollection('products');
        }

        return $product;
    }

    public function deleteProduct($product){
        $product->delete();
    }

}
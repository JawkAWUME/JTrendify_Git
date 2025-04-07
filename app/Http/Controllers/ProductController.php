<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function _construct() {
        $this->productService = $productService;
    }

    public function index(Request $request) {
        $query = Product::query();

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if($request->has('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        return response()->json($query->paginate(10));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Product::class);

        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $data['user_id'] = Auth::id();

        return response()->json($this->productService->createProduct($data), 201);
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|integer',
            'category_id' => 'sometimes|required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        return response()->json($this->productService->updateProduct($product, $data));
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $this->productService->deleteProduct($product);

        return response()->json(['message' => 'Product deleted']);
    }

    public function assignCategory(Request $request, Product $product)
    {
        $this->authorize('assignCategory', $product);

        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update(['category_id' => $data['category_id']]);

        return response()->json([
            'message' => 'Catégorie assignée avec succès',
            'product' => $product->load('category'),
        ]);
    }


}

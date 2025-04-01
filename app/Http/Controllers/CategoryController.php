<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::all());
    }

    public function show(Category $category) {
        return response()->json($category);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Category::class);

        $data = $request->validate(['name' => 'required|string|unique:categories']);

        return response()->json(Category::create($data), 201);
    }


    public function update(Request $request, Category $category) {
        $this->authorize('update', $category);

        $data = $request->validate([
            'name' => 'required|string|unique:categories,name,'.$category->id,
        ]);

        $category->update($data);

        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        $category->delete();

        return response()->json(['message' => 'Category deleted']);
    }

    public function addSubCategory(Request $request, Category $category) {
        $this->authorize('manageSubcategories', $category);

        $data = $request->validate([
            'name' => 'required|string|unique:categories',
        ]);

        $subcategory = new Category($data);
        $subcategory->parent_id = $category->id;
        $subcategory->save();

        return response()->json($subcategory,201);
    }

    public function removeSubCategory(Category $category, Category $subcategory) {
        $this->authorize('manageSubcategories', $category);

        if($subcategory->parent_id !== $category->id) {
            return response()->json(['error' => 'This subcategory does not belong to the given category'], 400);
        }

        $subcategory->delete();

        return response()->json(['message' => 'Subcategory deleted']);
    }

    public function getProducts(Category $category) {
        return response()->json($category->products);
    }

    public function filter(Request $request) {
        $query = Category::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('created_at')) {
            $query->where('created_at', $request->created_at);
        }

        return response()->json($query->get());
    }
    
}


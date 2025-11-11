<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // GET /api/categories

    public function index()
    {
        // Категории с изображением
        return ProductCategory::all()->map(function($category) {
            $data = $category->toArray();
            $data['image'] = $category->image ?? null;
            return $data;
        });
    }

    // GET /api/categories/{id}
    public function show($id)
    {
        $category = ProductCategory::findOrFail($id);
        $data = $category->toArray();
        $data['image'] = $category->image ?? null;
        $data['materials'] = $category->materials;
        return $data;
    }
}

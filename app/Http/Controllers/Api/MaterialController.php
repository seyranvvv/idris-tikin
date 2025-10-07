<?php

namespace App\Http\Controllers\Api;
use App\Models\Material;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
     public function index()
    {
        return Material::with(['category'  => function($query) {
            $query->select('m_cat_id', 'm_cat_name'); // Только нужные поля
        }])
           ->active()
            ->paginate(20);
    }
    
    public function show($id)
    {
        return Material::with(['category'])
            ->findOrFail($id);
    }
    
    public function search(Request $request)
    {
        $query = Material::query();
        
        if ($request->has('q')) {
            $query->where('material_name', 'like', '%'.$request->q.'%')
                  ->orWhere('material_code', 'like', '%'.$request->q.'%');
        }
        
        return $query->paginate(10);
    }
     public function byCategory($categoryId)
    {
        // Материалы по категории
        return Material::where('m_cat_id', $categoryId)
            ->with('category')
            ->paginate(20);
    }
}

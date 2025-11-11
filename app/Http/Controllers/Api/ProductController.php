<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // GET /api/products?category_id={id}
    public function index(Request $request)
    {
        $query = Material::on('sqlsrv')->with(['category', 'unit', 'images'])->active();
        
        // Фильтр по category_id (категория из PostgreSQL)
        if ($request->has('category_id')) {
            $categoryId = $request->input('category_id');
            
            // Получаем material_id из связующей таблицы
            $materialIds = DB::connection('pgsql')
                ->table('category_product_links')
                ->where('category_id', $categoryId)
                ->pluck('material_id');
            
            // Если нет связанных материалов, возвращаем пустой результат
            if ($materialIds->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'current_page' => 1,
                    'total' => 0,
                    'per_page' => 20
                ]);
            }
                
            $query->whereIn('material_id', $materialIds);
        }
        
        return $query->paginate(20);
    }
    
    // GET /api/products/{id}
    public function show($id)
    {
        return Material::on('sqlsrv')
            ->with(['category', 'unit', 'images'])
            ->where('material_id', $id)
            ->firstOrFail();
    }

    // GET /api/products/new/latest
    public function latest()
    {
        // Получаем последние 10 material_id из category_product_links
        $latestMaterialIds = DB::connection('pgsql')
            ->table('category_product_links')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->pluck('material_id');
        
        if ($latestMaterialIds->isEmpty()) {
            return response()->json([]);
        }

        return Material::on('sqlsrv')
            ->with(['category', 'unit', 'images'])
            ->active()
            ->whereIn('material_id', $latestMaterialIds)
            ->get();
    }

    // GET /api/products/popular/random
    public function popular()
    {
        // Получаем случайные 10 material_id из category_product_links
        $randomMaterialIds = DB::connection('pgsql')
            ->table('category_product_links')
            ->inRandomOrder()
            ->limit(10)
            ->pluck('material_id');
        
        if ($randomMaterialIds->isEmpty()) {
            return response()->json([]);
        }

        return Material::on('sqlsrv')
            ->with(['category', 'unit', 'images'])
            ->active()
            ->whereIn('material_id', $randomMaterialIds)
            ->get();
    }

    // GET /api/products/filter/recommended - Рекомендуемые (случайные 20)
    public function recommended()
    {
        $randomMaterialIds = DB::connection('pgsql')
            ->table('category_product_links')
            ->inRandomOrder()
            ->limit(20)
            ->pluck('material_id');
        
        if ($randomMaterialIds->isEmpty()) {
            return response()->json([]);
        }

        return Material::on('sqlsrv')
            ->with(['category', 'unit', 'images'])
            ->active()
            ->whereIn('material_id', $randomMaterialIds)
            ->get();
    }

    // GET /api/products/filter/views - По популярности (случайный порядок, имитация просмотров)
    public function views()
    {
        $materialIds = DB::connection('pgsql')
            ->table('category_product_links')
            ->inRandomOrder()
            ->limit(20)
            ->pluck('material_id');
        
        if ($materialIds->isEmpty()) {
            return response()->json([]);
        }

        return Material::on('sqlsrv')
            ->with(['category', 'unit', 'images'])
            ->active()
            ->whereIn('material_id', $materialIds)
            ->get();
    }

    // GET /api/products/filter/cheap - От дешевых к дорогим
    public function cheap()
    {
        $materialIds = DB::connection('pgsql')
            ->table('category_product_links')
            ->pluck('material_id');
        
        if ($materialIds->isEmpty()) {
            return response()->json([]);
        }

        return Material::on('sqlsrv')
            ->with(['category', 'unit', 'images'])
            ->where('tbl_mg_materials.a_status_id', 1)
            ->whereIn('tbl_mg_materials.material_id', $materialIds)
            ->leftJoin('tbl_mg_mat_price', function($join) {
                $join->on('tbl_mg_materials.material_id', '=', 'tbl_mg_mat_price.material_id')
                     ->where('tbl_mg_mat_price.price_type_id', '=', 2);
            })
            ->select('tbl_mg_materials.*', 'tbl_mg_mat_price.price_value')
            ->orderBy('tbl_mg_mat_price.price_value', 'asc')
            ->limit(20)
            ->get();
    }

    // GET /api/products/filter/expensive - От дорогих к дешевым
    public function expensive()
    {
        $materialIds = DB::connection('pgsql')
            ->table('category_product_links')
            ->pluck('material_id');
        
        if ($materialIds->isEmpty()) {
            return response()->json([]);
        }

        return Material::on('sqlsrv')
            ->with(['category', 'unit', 'images'])
            ->where('tbl_mg_materials.a_status_id', 1)
            ->whereIn('tbl_mg_materials.material_id', $materialIds)
            ->leftJoin('tbl_mg_mat_price', function($join) {
                $join->on('tbl_mg_materials.material_id', '=', 'tbl_mg_mat_price.material_id')
                     ->where('tbl_mg_mat_price.price_type_id', '=', 2);
            })
            ->select('tbl_mg_materials.*', 'tbl_mg_mat_price.price_value')
            ->orderBy('tbl_mg_mat_price.price_value', 'desc')
            ->limit(20)
            ->get();
    }

    // GET /api/products/filter/latest - Новинки (последние добавленные)
    public function filterLatest()
    {
        $latestMaterialIds = DB::connection('pgsql')
            ->table('category_product_links')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->pluck('material_id');
        
        if ($latestMaterialIds->isEmpty()) {
            return response()->json([]);
        }

        return Material::on('sqlsrv')
            ->with(['category', 'unit', 'images'])
            ->active()
            ->whereIn('material_id', $latestMaterialIds)
            ->get();
    }

    // GET /api/products/search?q=текст
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (!$query || strlen($query) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Минимальная длина поискового запроса - 2 символа',
                'data' => []
            ], 400);
        }

        // Получаем material_id из category_product_links (только те что в каталоге)
        $catalogMaterialIds = DB::connection('pgsql')
            ->table('category_product_links')
            ->pluck('material_id');

        if ($catalogMaterialIds->isEmpty()) {
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        }

        // Ищем по названию или коду материала
        $materials = Material::on('sqlsrv')
            ->with(['category', 'unit', 'images'])
            ->active()
            ->whereIn('material_id', $catalogMaterialIds)
            ->where(function($q) use ($query) {
                $q->where('material_name', 'like', '%' . $query . '%')
                  ->orWhere('material_code', 'like', '%' . $query . '%');
            })
            ->limit(50)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $materials,
            'count' => $materials->count()
        ]);
    }
}
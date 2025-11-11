<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
class MaterialCategoryLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $materials = \App\Models\Material::on('sqlsrv')->orderBy('material_name')->paginate(50);
        return view('material_category_links.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $material_id)
    {
         $request->validate([
                'category_id' => 'required|exists:pgsql.product_categories,id',
            ]);
            DB::connection('pgsql')->table('category_product_links')->insert([
                'material_id' => $material_id,
                'category_id' => $request->category_id,
            ]);
            return redirect()->route('material-category-links.edit', $material_id)->with('success', 'Категория добавлена!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($material_id)
    {
    $material = Material::on('sqlsrv')->findOrFail($material_id);
        $categories = ProductCategory::on('pgsql')->get();
        return view('material_category_links.edit', compact('material', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
    public function destroy($material_id, $category_id)
    {
        DB::connection('pgsql')->table('category_product_links')
            ->where('material_id', $material_id)
            ->where('category_id', $category_id)
            ->delete();
        return redirect()->route('material-category-links.edit', $material_id)->with('success', 'Категория удалена!');
    }
}

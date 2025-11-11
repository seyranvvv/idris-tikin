<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Material extends Model
{
    protected $connection = 'sqlsrv';
     protected $table = 'tbl_mg_materials';
    protected $primaryKey = 'material_id';
    
    protected $fillable = [
         'material_id',
        'material_code', 
        'material_name',
        'firm_id',
        'm_cat_id',
        'unit_id',
        'a_status_id'
    ];
    
  public function prices()
{
    return $this->hasMany(Price::class, 'material_id')
        ->from('tbl_mg_mat_price'); // Явно указываем имя таблицы
}
protected $appends = ['sale_price', 'stock_quantity']; // Добавляем поле в JSON

public function getSalePriceAttribute()
{
    $salePrice = $this->prices()
        ->where('price_type_id', 2)
        ->first();

    return $salePrice ? $salePrice->price_value : null;
}

public function getStockQuantityAttribute()
{
    // Получаем количество товара из view v_mg_stock
    $result = DB::connection('sqlsrv')
        ->table('v_mg_stock')
        ->where('material_id', $this->material_id)
        ->where('wh_id', -1) // -1 означает суммарный остаток по всем складам
        ->select('mat_whousetotal_amount')
        ->first();
    
    return $result->mat_whousetotal_amount ?? 0;
}
    
    public function barcodes()
    {
        return $this->hasMany(Barcode::class, 'material_id');
    }
    
    public function category()
    {
        return $this->belongsTo(MaterialCategory::class, 'm_cat_id', 'm_cat_id');
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id');
    }

    public function scopeActive($query)
{
    return $query->where('a_status_id', 1);
}


// Кастомный аксессор для получения категорий из другой БД
public function getCustomCategoriesAttribute()
{
    $categoryIds = DB::connection('pgsql')
        ->table('category_product_links')
        ->where('material_id', $this->material_id)
        ->pluck('category_id');

    return ProductCategory::on('pgsql')
        ->whereIn('id', $categoryIds)
        ->get();
}

public function images()
{
    return $this->hasMany(
        \App\Models\ProductImage::class,
        'material_id',
        'material_id'
    );
}
}

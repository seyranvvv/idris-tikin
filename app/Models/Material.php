<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
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
protected $appends = ['sale_price']; // Добавляем поле в JSON

public function getSalePriceAttribute()
{
    $salePrice = $this->prices()
        ->where('price_type_id', 2)
        ->first();

    return $salePrice ? $salePrice->price_value : null;
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
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function scopeActive($query)
{
    return $query->where('a_status_id', 1);
}
}

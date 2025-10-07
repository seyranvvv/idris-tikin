<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = 'tbl_mg_mat_price';
    protected $primaryKey = 'price_id'; // Укажите правильный первичный ключ
    
    protected $fillable = [
        'material_id',
        'price_value',
        'price_type_id',
        'unit_det_id',
        // другие поля
    ];
    
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}

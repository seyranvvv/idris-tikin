<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialCategory extends Model
{
    protected $table = 'tbl_mg_material_category';
    protected $primaryKey = 'm_cat_id'; // Соответствует первичному ключу в таблице
    
    protected $fillable = [
        'm_cat_id',
        'm_cat_name',
        'm_cat_desc',
        'firm_id',
        'm_cat_id_gud'
    ];
    
    public function materials()
    {
        return $this->hasMany(Material::class, 'm_cat_id', 'm_cat_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class ProductCategory extends Model
{
    protected $connection = 'pgsql'; // важно!
    protected $table = 'product_categories';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name_tm',
        'name_ru',
        'name_en',
        'image',
    ];

    // Кастомный аксессор для получения связанных материалов между двумя БД
    public function getMaterialsAttribute()
    {
        $materialIds = DB::connection('pgsql')
            ->table('category_product_links')
            ->where('category_id', $this->id)
            ->pluck('material_id');

        return \App\Models\Material::on('sqlsrv')
            ->whereIn('material_id', $materialIds)
            ->get();
    }

}

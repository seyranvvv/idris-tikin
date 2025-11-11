<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProductLink extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'category_product_links';

    protected $fillable = [
        'category_id',
        'material_id'
    ];
}

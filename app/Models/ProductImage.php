<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
     protected $connection = 'pgsql';
    protected $table = 'product_images';

    protected $fillable = [
        'material_id',
        'image_path',
    ];
}

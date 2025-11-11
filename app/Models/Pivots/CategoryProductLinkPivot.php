<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
class CategoryProductLinkPivot extends Model
{
    protected $connection = 'pgsql'; // или mysql, если ты используешь mysql
    protected $table = 'category_product_links';
    public $incrementing = true;
}

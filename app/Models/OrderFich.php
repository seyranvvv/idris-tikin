<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderFich extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'tbl_mg_order_fich';
    protected $primaryKey = 'fich_id';
    public $timestamps = false;

    protected $fillable = [
        'fich_code',
        'fich_date',
        'fich_total',
        'fich_create_date',
        'fich_type_id',
        'arap_id',
        'div_id',
        'dept_id',
        'plant_id',
        'wh_id',
        'p_id',
        'inv_id',
        'fich_desc',
        'fich_discount',
        'fich_nettotal',
        'salesman_id',
        'T_ID',
        'ord_status_id',
        'fich_nettotal_text',
        'term_id',
    ];

    public function traces()
    {
        return $this->hasMany(OrderTrace::class, 'fich_id', 'fich_id');
    }
}

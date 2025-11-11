<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTrace extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'tbl_mg_order_trace';
    protected $primaryKey = 'order_trave_id';
    public $timestamps = false;

    protected $fillable = [
        'order_change_date',
        'order_desc',
        'inv_id',
        'fich_id',
        'order_remind_date',
        'ord_status_id',
        'firm_id',
        'T_ID',
        'order_color',
    ];

    public function orderFich()
    {
        return $this->belongsTo(OrderFich::class, 'fich_id', 'fich_id');
    }
}

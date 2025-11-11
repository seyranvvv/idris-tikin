<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'orders';

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_phone',
        'customer_email',
        'delivery_location_id',
        'total_amount',
        'delivery_type',
        'payment_method',
        'delivery_cost',
        'final_amount',
        'status',
        'notes',
        'delivery_date',
        'sql_server_fich_id',
        'synced_to_sqlserver',
        'synced_at',
    ];

    protected $casts = [
        'synced_to_sqlserver' => 'boolean',
        'synced_at' => 'datetime',
        'delivery_date' => 'date',
        'total_amount' => 'decimal:2',
        'delivery_cost' => 'decimal:2',
        'final_amount' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function deliveryLocation()
    {
        return $this->belongsTo(DeliveryLocation::class);
    }
}

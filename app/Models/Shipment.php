<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $primaryKey = 'shipment_id';
    
    protected $fillable = [
        'order_id',
        'shipping_date',
        'estimated_delivery',
        'actual_delivery',
        'status'
    ];


    protected $casts = [
        'shipping_date' => 'datetime',
        'estimated_delivery' => 'datetime',
        'actual_delivery' => 'datetime',
    ];

    
    public $timestamps = false;

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftBox extends Model
{
    protected $table = 'gift_boxes';
    protected $primaryKey = 'box_id';
    
    protected $fillable = [
        'order_id', 'flower_id', 'chocolate_id', 'packaging_id',
        'quantity', 'price', 'custom_message'
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function flower()
    {
        return $this->belongsTo(Product::class, 'flower_id');
    }

    public function chocolate()
    {
        return $this->belongsTo(Product::class, 'chocolate_id');
    }

    public function packaging()
    {
        return $this->belongsTo(Product::class, 'packaging_id');
    }
}

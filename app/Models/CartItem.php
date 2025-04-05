<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $primaryKey = 'cart_item_id';
    
    protected $fillable = [
        'user_id',
        'flower_id',
        'chocolate_id',
        'packaging_id',
        'quantity',
        'custom_message'
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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

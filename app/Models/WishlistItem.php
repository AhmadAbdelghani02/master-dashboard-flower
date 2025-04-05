<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishlistItem extends Model
{
    protected $primaryKey = 'wishlist_item_id';
    
    protected $fillable = [
        'wishlist_id',
        'flower_id',
        'chocolate_id',
        'packaging_id'
    ];

    public $timestamps = false;

    // Relationships
    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class, 'wishlist_id');
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


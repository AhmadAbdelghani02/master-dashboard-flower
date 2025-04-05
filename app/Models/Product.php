<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    
    protected $fillable = [
        'category_id', 'name', 'description', 'price', 'stock_quantity',
        'image_url', 'is_active'
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function flowerGiftBoxes()
    {
        return $this->hasMany(GiftBox::class, 'flower_id');
    }

    public function chocolateGiftBoxes()
    {
        return $this->hasMany(GiftBox::class, 'chocolate_id');
    }

    public function packagingGiftBoxes()
    {
        return $this->hasMany(GiftBox::class, 'packaging_id');
    }

    public function flowerCartItems()
    {
        return $this->hasMany(CartItem::class, 'flower_id');
    }

    public function chocolateCartItems()
    {
        return $this->hasMany(CartItem::class, 'chocolate_id');
    }

    public function packagingCartItems()
    {
        return $this->hasMany(CartItem::class, 'packaging_id');
    }

    public function flowerWishlistItems()
    {
        return $this->hasMany(WishlistItem::class, 'flower_id');
    }

    public function chocolateWishlistItems()
    {
        return $this->hasMany(WishlistItem::class, 'chocolate_id');
    }

    public function packagingWishlistItems()
    {
        return $this->hasMany(WishlistItem::class, 'packaging_id');
    }
}

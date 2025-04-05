<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $primaryKey = 'wishlist_id';
    
    protected $fillable = [
        'user_id',
        'name'
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function wishlistItems()
    {
        return $this->hasMany(WishlistItem::class, 'wishlist_id');
    }
}

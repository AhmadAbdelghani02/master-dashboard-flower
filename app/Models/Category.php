<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    
    protected $fillable = [
        'name',
        'description',
        'display_order'
    ];

    public $timestamps = false;

    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}


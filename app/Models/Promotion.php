<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $primaryKey = 'promotion_id';
    
    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'minimum_order',
        'start_date',
        'end_date',
        'is_active',
        'usage_limit',
        'usage_count'
    ];

    public $timestamps = false;

    // Relationships
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_promotions', 'promotion_id', 'order_id')
            ->withPivot('discount_amount');
    }
}
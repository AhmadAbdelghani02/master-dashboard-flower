<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    
    protected $fillable = [
        'user_id', 'order_date', 'total_amount', 'shipping_address_id',
        'billing_address_id', 'status', 'notes'
    ];

    const CREATED_AT = 'order_date';
    const UPDATED_AT = null;

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id');
    }

    public function shipments()
    {
        return $this->hasOne(Shipment::class, 'order_id');
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'order_promotions', 'order_id', 'promotion_id')
            ->withPivot('discount_amount');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $primaryKey = 'payment_id';
    
    protected $fillable = [
        'order_id',
        'amount',
        'payment_method',
        'transaction_id',
        'status'
    ];

    const CREATED_AT = 'payment_date';
    const UPDATED_AT = null;

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}

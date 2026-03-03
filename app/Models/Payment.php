<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'order_id',
        'payment_method',   // cash / card / online
        'transaction_id',
        'payment_status',   // pending / completed / failed
        'amount',
        'paid_at'
    ];

    // Payment belongs to order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Payment belongs to user (customer) through order
    public function user()
    {
        // If you have the staudenmeir/eloquent-has-many-deep package, use belongsToThrough
        // Otherwise, fallback to accessing user via order
        return $this->order ? $this->order->user : null;
    }
}

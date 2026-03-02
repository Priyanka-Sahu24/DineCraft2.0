<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'order_number',
        'user_id',
        'table_id',
        'staff_id',
        'order_type',      // dine-in / online
        'order_status'     // pending / completed / cancelled
    ];

    // Order has many order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Order belongs to a customer (user)
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    // Order handled by a staff
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    // Order linked to a table
    public function table()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }

    // Payment of this order
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }
}

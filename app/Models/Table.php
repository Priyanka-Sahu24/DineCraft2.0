<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $table = 'tables';

    protected $fillable = [
        'table_number',
        'capacity',
        'location',
        'status'   // available / occupied
    ];

    // Table may have many orders
    public function orders()
    {
        return $this->hasMany(Order::class, 'table_id');
    }

     public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory'; 

    protected $fillable = [
        'item_name',
        'unit',
        'quantity',
        'low_alert',
        'price',
        'note'
    ];
}

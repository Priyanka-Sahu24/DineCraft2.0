<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = [
        'staff_id',
        'from_date',
        'to_date',
        'reason',
        'status'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
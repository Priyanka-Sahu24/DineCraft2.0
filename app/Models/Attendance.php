<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'staff_id',
        'date',
        'status',
        'check_in',
        'check_out'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
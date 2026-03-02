<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $fillable = [
        'staff_id',
        'basic_salary',
        'bonus',
        'deduction',
        'net_salary',
        'month',
        'year',
        'status',
        'paid_date'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
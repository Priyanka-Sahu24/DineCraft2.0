<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'user_id',         // link to users table
        'employee_id',
        'designation',
        'salary',
        'joining_date',
        'shift',
        'status',
    ];

    // Staff may have many orders they handle
    public function orders()
    {
        return $this->hasMany(Order::class, 'staff_id');
    }

    // Optional: link to user account
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function attendances()
    {
    return $this->hasMany(Attendance::class);
    }

    public function leaves()
   {
    return $this->hasMany(Leave::class);
   }
}

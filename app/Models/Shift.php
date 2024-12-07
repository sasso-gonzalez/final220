<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\ShiftController; //not sure if this is necessary.

use App\Models\Employee;


class Shift extends Model
{
    use HasFactory;


    // public $incrementing = false; // Since 'role' is not an integer and not auto-incrementing
    protected $keyType = 'string';
    protected $primaryKey = 'id'; 

    protected $fillable = [
        'emp_id',
        'caregroup', 
        'shift_date',
        'shift_start',
        'shift_end',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'emp_id');
    }

    // Define relationship with the User model
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $primaryKey = 'meds_id';

    protected $fillable = [
        // 'meds_id',
        'appointment_id',
        'doctor_id',
        'doc_notes',
        'm_med',
        'a_med',
        'n_med',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class,'appointment_id', 'appointment_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Employee::class, 'doctor_id', 'emp_id');
    }
}

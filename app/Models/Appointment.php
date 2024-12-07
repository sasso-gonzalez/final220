<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{    
    use HasFactory;

    protected $primaryKey = 'appointment_id';   
    protected $fillable = [
        // 'appointment_id',
        'patient_id',
        'doctor_id',
        'app_notes',
        'app_date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'doctor_id', 'emp_id');//changed emp to doctor
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'patient_id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'appointment_id', 'appointment_id');
    }

}

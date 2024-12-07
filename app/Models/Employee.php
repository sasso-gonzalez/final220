<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Shift;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'emp_id';
    protected $fillable = [
        // 'emp_id',
        'user_id',
        'salary',
    ];

    // public $incrementing = false; //for something like roles where it tries to increment strings/letters -serena

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function shifts()
    {
        return $this->hasMany(Shift::class, 'emp_id', 'emp_id');
    }


    public function scopeByRole($query, $role)
    {
        return $query->whereHas('user', function ($q) use ($role) {
            $q->where('role', $role);
        });
    }
    
    public function patientSchedules()
    {
        return $this->hasMany(PatientSchedule::class, 'caregiver_id', 'emp_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id', 'emp_id');//changed to doctor_id
    }
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'doctor_id', 'emp_id');
    }

}


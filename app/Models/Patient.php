<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Patient extends Model
{
    use HasFactory;

    protected $primaryKey = 'patient_id';
    protected $dates = ['payment_date', 'admission_date']; 
    protected $fillable = [
        // 'patient_id',
        'user_id',
        'family_code',
        'caregroup',
        'amount_due',
        'admission_date',
        'payment_date',
    ];


// user model relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function patientSchedules()
    {
        return $this->hasMany(PatientSchedule::class, 'patient_id', 'patient_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id', 'patient_id');
    }
    
}

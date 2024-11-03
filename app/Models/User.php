<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type_id',
        'active_status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function patientDetails()
    {
        return $this->hasOne(Patient_details::class, 'user_id');
    }

    public function doctorPatients()
    {
        return $this->hasMany(PatientDoctorRelationship::class, 'doctor_id');
    }

    public function doctors()
    {
        return $this->hasMany(PatientDoctorRelationship::class, 'patient_id');
    }
}


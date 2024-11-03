<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientDoctorRelationship extends Model
{
    protected $table = 'patient_doctor_relationship';

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'created_at',
        'updated_at'
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}

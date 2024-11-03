<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient_details extends Model
{
    protected $table = 'patient_details';

    protected $fillable = [
        'user_id',
        'phone_no',
        'age',
        'weight',
        'gender'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

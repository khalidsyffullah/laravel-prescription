<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class DoctorInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'bef_name',
        'bmdc_registration_no',
        'phone_no',
        'user_id',
        'degree',
        'specialist',
        'sub_specialist',
        'Experience',
        'active_status'
    ];
    protected $table = 'doctor_info';


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

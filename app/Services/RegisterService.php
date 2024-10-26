<?php
//registerservice
namespace App\Services;

use App\Models\User;
use App\Models\DoctorInfo;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    public function register(array $data)
    {
        // Create a new user
        $user = User::create([
            'name' => '',  // Optional, left blank
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type_id' => 2,  // Doctor user type
        ]);

        // Create doctor information
        DoctorInfo::create([
            'bef_name' => '',  // Optional, left blank
            'bmdc_registration_no' => $data['bmdc_registration_no'],
            'phone_no' => $data['phone_no'],
            'user_id' => $user->id,
            'degree' => '',  // Optional, left blank
            'specialist' => '',  // Optional, left blank
            'sub_specialist' => '',  // Optional, left blank
            'Experience' => '',  // Optional, left blank
            'active_status' => 'inactive',  // Default to inactive
        ]);

        return $user; // Return the created user (if needed)
    }
}

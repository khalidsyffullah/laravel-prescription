<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\DoctorInfo;

class LoginService
{
    public function attemptLogin($credentials)
    {
        $identifier = $credentials['email_or_phone'];
        $password = $credentials['password'];

        // First, try to find the user by email
        $user = User::where('email', $identifier)->first();

        // If user not found by email, try to find by phone number in doctor_info
        if (!$user) {
            $doctorInfo = DoctorInfo::where('phone_no', $identifier)->first();
            if ($doctorInfo) {
                $user = User::find($doctorInfo->user_id);
            }
        }

        // If no user found with either email or phone
        if (!$user) {
            return false;
        }

        // Check if user has an active status and is a doctor
        $doctorInfo = DoctorInfo::where('user_id', $user->id)->first();
        if ($doctorInfo && $doctorInfo->active_status !== 'active') {
            return 'inactive';
        }

        // Attempt authentication with email only
        if (Auth::attempt(['email' => $user->email, 'password' => $password])) {
            return true;
        }

        return false;
    }
}

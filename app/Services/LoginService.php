<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\DoctorInfo;

class LoginService
{
    public function attemptLogin($credentials)
    {
        // Determine if the provided credential is an email or a phone
        $field = filter_var($credentials['email'] ?? $credentials['phone'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $password = $credentials['password'];

        // Attempt to retrieve the user based on the identified field (email or phone)
        $user = User::where($field, $credentials[$field])->first();

        // If the user does not exist, return false
        if (!$user) {
            return false;
        }

        // Retrieve the associated DoctorInfo
        $doctorInfo = DoctorInfo::where('user_id', $user->id)->first();

        // Check if the user is inactive
        if ($doctorInfo && $doctorInfo->active_status !== 'active') {
            return 'inactive';
        }

        // Attempt to log the user in
        if (Auth::attempt([$field => $credentials[$field], 'password' => $password])) {
            return true;
        }

        // Return false if the login attempt fails
        return false;
    }
}

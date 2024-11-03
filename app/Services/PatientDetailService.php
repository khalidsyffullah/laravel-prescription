<?php

namespace App\Services;

use App\Models\User;
use App\Models\Patient_details;
use App\Models\PatientDoctorRelationship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PatientDetailService {
    public function createNewPatient(array $data) {
        try {
            DB::beginTransaction();

            // Create new patient user
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make(Str::random(10)),
                'user_type_id' => 3, // Patient type
            ]);

            // Create patient details
            $patientDetails = Patient_details::create([
                'user_id' => $user->id,
                'phone_no' => $data['phone_no'],
                'age' => $data['age'],
                'weight' => $data['weight'],
                'gender' => $data['gender']
            ]);

            // Create doctor-patient relationship
            PatientDoctorRelationship::create([
                'doctor_id' => Auth::id(),
                'patient_id' => $user->id
            ]);

            DB::commit();
            return $user;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}

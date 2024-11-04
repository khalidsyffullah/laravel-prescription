<?php
// Controller: App/Http/Controllers/patientDetailsController.php

namespace App\Http\Controllers;

use App\Http\Requests\patientDetailsRequest;
use Illuminate\Http\Request;
use App\Services\PatientDetailService;
use App\Models\User;
use App\Models\Patient_details;
use App\Models\PatientDoctorRelationship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class patientDetailsController extends Controller
{
    protected $patientDetails;

    public function __construct(PatientDetailService $patientDetails){
        $this->patientDetails = $patientDetails;
    }

    public function index(){
        return view('users.doctors.patients.patient');
    }

    public function checkPatient(Request $request) {
        $name = $request->input('name');
        $phone = $request->input('phone_no');

        $user = User::whereHas('patientDetails', function($query) use ($phone) {
                $query->where('phone_no', $phone);
            })
            ->where('name', $name)
            ->with(['patientDetails', 'doctors'])
            ->first();

        if ($user) {
            // Check if current doctor is already linked to this patient
            $isLinked = $user->doctors()
                ->where('doctor_id', Auth::id())
                ->exists();

            return response()->json([
                'exists' => true,
                'isLinked' => $isLinked,
                'patient' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'age' => $user->patientDetails->age,
                    'weight' => $user->patientDetails->weight,
                    'gender' => $user->patientDetails->gender,
                    'phone_no' => $user->patientDetails->phone_no
                ]
            ]);
        }

        return response()->json(['exists' => false]);
    }

    public function update(Request $request) {
        try {
            $patientId = $request->input('patient_id');
            $doctorId = Auth::id();

            // Check if relationship already exists
            $existingRelationship = PatientDoctorRelationship::where('doctor_id', $doctorId)
                ->where('patient_id', $patientId)
                ->first();

            if ($existingRelationship) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This patient is already linked to your account'
                ]);
            }

            // Create new relationship
            PatientDoctorRelationship::create([
                'doctor_id' => $doctorId,
                'patient_id' => $patientId
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Patient successfully linked to your account'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while processing your request'
            ]);
        }
    }

    public function store(patientDetailsRequest $request)
{
    try {
        // Retrieve the validated data
        $data = $request->validated();

        // Set default values if fields are empty
        $data['email'] = $data['email'] ?? 'demo@email.com';
        $data['gender'] = $data['gender'] ?? 'male';
        $data['phone_no'] = $data['phone_no'] ?? '123456';
        $data['age'] = 30;
        $data['weight'] = 20;

        // Create a new patient detail entry
        $patientDetail = $this->patientDetails->createNewPatient($data);

        return redirect()->back()->with('success', 'Patient created successfully');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error creating patient: ' . $e->getMessage())->withInput();
    }
}

}

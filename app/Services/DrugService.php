<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\prescriptions\Drug;
use Exception;
use Illuminate\Support\Facades\Log;

class DrugService
{
    public function createDrug(array $data)
    {
        try {
            // Get the authenticated user's ID
            $userid = Auth::id();
            $data['user_id'] = $userid;

            // Attempt to create the drug record
            return Drug::create($data);
        } catch (Exception $e) {
            // Log the exception
            Log::error('Error creating drug: ' . $e->getMessage());

            // Optionally, you can return a custom error message or handle it in a way you prefer
            return response()->json([
                'success' => false,
                'message' => 'Failed to create drug. Please try again later.',
            ], 500);
        }
    }
    public function search(string $keyword){
        return Drug::where('user_id', Auth::id())
        ->where('name', 'LIKE', "%{$keyword}%")
        ->get();
    }
    public function findDrugByName(string $name){
        return Drug::where('user_id', Auth::id())
        ->where('name', "%{$name}%")
        ->first();

    }
}

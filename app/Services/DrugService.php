<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\prescriptions\Drug;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class DrugService
{
    public function createDrug(array $data)
    {
        try {
            // Get the authenticated user's ID
            $userid = Auth::id();
            $data['user_id'] = $userid;
            $existingDrugs =Drug::where('name',$data['name'])
            ->where('user_id', $userid)
            ->first();
            if($existingDrugs){
                return $existingDrugs;
            }

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
    public function storeDrugSelectionInSession(array $newSelection)
    {
        // Retrieve existing selections from session
        $selectedDrugs = Session::get('selectedDrugs', []);

        // Check if the new selection is already in the session
        if (!in_array($newSelection, $selectedDrugs)) {
            $selectedDrugs[] = $newSelection; // Add only if not already present
            Session::put('selectedDrugs', $selectedDrugs); // Update the session
        }

        return $selectedDrugs;
    }


    public function removeDrugSelectionFromSession(int $id)
    {
        // Retrieve existing selections from session
        $selectedDrugs = Session::get('selectedDrugs', []);

        // Filter out the selected item by matching the ID
        $selectedDrugs = array_filter($selectedDrugs, function ($item) use ($id) {
            return $item['id'] != $id;
        });

        // Reindex the array to avoid issues with JavaScript handling
        $selectedDrugs = array_values($selectedDrugs);
        Session::put('selectedDrugs', $selectedDrugs);

        return $selectedDrugs;
    }
}

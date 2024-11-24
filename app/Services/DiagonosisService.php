<?php

namespace App\Services;

use App\Models\prescriptions\Diagonosis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class DiagonosisService
{
    public function createDiagonosis(array $data)
    {
        $userId = Auth::id();
        $data['user_id'] = $userId;
        // Check if a diagnosis with the same name already exists for the user
        $existingDiagnosis = Diagonosis::where('name', $data['name'])
            ->where('user_id', $userId)
            ->first();

        if ($existingDiagnosis) {
            // Return existing diagnosis instead of creating a new one
            return $existingDiagnosis;
        }

        // Create new diagnosis if no existing record found
        return Diagonosis::create($data);
    }

    public function search(string $keyword)
    {
        return Diagonosis::where('user_id', Auth::id())
            ->where('name', 'LIKE', "%{$keyword}%")
            ->get();
    }

    public function findDiagnosisByName(string $name)
    {
        return Diagonosis::where('user_id', Auth::id())
            ->where('name', $name)
            ->first(); // Return the first matching record or null
    }
    public function storeDiagonosisSelectionInSession(array $newSelection)
    {
        // Retrieve existing selections from session
        $selectedDiagnoses = Session::get('selectedDiagnoses', []);

        // Check if the new selection is already in the session
        if (!in_array($newSelection, $selectedDiagnoses)) {
            $selectedDiagnoses[] = $newSelection; // Add only if not already present
            Session::put('selectedDiagnoses', $selectedDiagnoses); // Update the session
        }

        return $selectedDiagnoses;
    }


    public function removeDiagonosisSelectionFromSession(int $id)
    {
        // Retrieve existing selections from session
        $selectedDiagnoses = Session::get('selectedDiagnoses', []);

        // Filter out the selected item by matching the ID
        $selectedDiagnoses = array_filter($selectedDiagnoses, function ($item) use ($id) {
            return $item['id'] != $id;
        });

        // Reindex the array to avoid issues with JavaScript handling
        $selectedDiagnoses = array_values($selectedDiagnoses);
        Session::put('selectedDiagnoses', $selectedDiagnoses);

        return $selectedDiagnoses;
    }
}

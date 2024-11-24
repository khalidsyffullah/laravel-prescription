<?php

namespace App\Services;

use App\Models\prescriptions\Advise_investigation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class AdviceInvestigationService
{
    public function createAdviceInvestigation(array $data)
    {
        $userId = Auth::id();
        $data['user_id'] = $userId;
        $existingAdviceInvestigation = Advise_investigation::where('user_id', $userId)
            ->where('name', $data['name'])
            ->first();
        if ($existingAdviceInvestigation) {
            return $existingAdviceInvestigation;
        }
        return Advise_investigation::create($data);
    }
    public function search(string $keyword)
    {
        return Advise_investigation::where('user_id', Auth::id())
            ->where('name', 'LIKE', "%{$keyword}%")
            ->get();
    }
    public function findAdviceInvestigationByName(string $name)
    {

        return Advise_investigation::where('user_id', Auth::id())
            ->where('name', "%{$name}%")
            ->first();
    }



    public function storeadviceInvestigationSelectionInSession(array $newSelection)
    {
        // Retrieve existing selections from session and add new selection
        $selectedAdviceInvestigations = Session::get('selectedAdviceInvestigations', []);
        if(!in_array($newSelection, $selectedAdviceInvestigations)){
            $selectedAdviceInvestigations[] = $newSelection;
        Session::put('selectedAdviceInvestigations', $selectedAdviceInvestigations);

        }

        return $selectedAdviceInvestigations;
    }

    public function removeAdviceInvestigationSelectionFromSession(int $id)
    {
        // Retrieve existing selections from session
        $selectedAdviceInvestigations = Session::get('selectedAdviceInvestigations', []);

        // Filter out the selected item by matching the ID
        $selectedAdviceInvestigations = array_filter($selectedAdviceInvestigations, function ($item) use ($id) {
            return $item['id'] != $id;
        });

        // Reindex the array to avoid issues with JavaScript handling
        $selectedAdviceInvestigations = array_values($selectedAdviceInvestigations);
        Session::put('selectedAdviceInvestigations', $selectedAdviceInvestigations);

        return $selectedAdviceInvestigations;
    }


    // public function storeAdviceInvestigationsSelectionInSession(array $newSelection)
    // {
    //     // Retrieve existing selections from session
    //     $selectedAdviceInvestigations = Session::get('selectedAdviceInvestigations', []);

    //     // Check if the new selection is already in the session
    //     if (!in_array($newSelection, $selectedAdviceInvestigations)) {
    //         $selectedAdviceInvestigations[] = $newSelection; // Add only if not already present
    //         Session::put('selectedAdviceInvestigations', $selectedAdviceInvestigations); // Update the session
    //     }

    //     return $selectedAdviceInvestigations;
    // }


    public function removeAdviceInvestigationsSelectionFromSession(int $id)
    {
        // Retrieve existing selections from session
        $selectedAdviceInvestigations = Session::get('selectedAdviceInvestigations', []);

        // Filter out the selected item by matching the ID
        $selectedAdviceInvestigations = array_filter($selectedAdviceInvestigations, function ($item) use ($id) {
            return $item['id'] != $id;
        });

        // Reindex the array to avoid issues with JavaScript handling
        $selectedAdviceInvestigations = array_values($selectedAdviceInvestigations);
        Session::put('selectedAdviceInvestigations', $selectedAdviceInvestigations);

        return $selectedAdviceInvestigations;
    }
}

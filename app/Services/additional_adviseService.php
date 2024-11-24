<?php
namespace App\Services;
use App\Models\prescriptions\Aditional_advises;
use illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class additional_adviseService{
    public function storeAdditionalAdviceData(array $data){
        $userId = Auth::id();
        $data['user_id'] = $userId;
        // existing additional advice check
        $existingAdditionalAdvice = Aditional_advises::where('name', $data['name'])
        ->where('user_id', $userId)
        ->first();
        if($existingAdditionalAdvice){
            return $existingAdditionalAdvice;
        }
        return Aditional_advises::create($data);



    }

    public function search(string $keyword){

        return Aditional_advises::where('user_id', Auth::id())
        ->where('name','LIKE',"%{$keyword}%")
        ->get();
    }

    public function findAdditionalAdviceServiceByName(string $name){
        return Aditional_advises::where('user_id', Auth::id())
        ->where('name', "%{$name}%")
        ->first();
    }

    public function storeAdditionalAdviceSelectionInSession(array $newSelection)
    {
        // Retrieve existing selections from session
        $selectedAdditionalAdvices = Session::get('selectedAdditionalAdvices', []);

        // Check if the new selection is already in the session
        if (!in_array($newSelection, $selectedAdditionalAdvices)) {
            $selectedAdditionalAdvices[] = $newSelection; // Add only if not already present
            Session::put('selectedAdditionalAdvices', $selectedAdditionalAdvices); // Update the session
        }

        return $selectedAdditionalAdvices;
    }


    public function removeAdditionalAdviceSelectionFromSession(int $id)
    {
        // Retrieve existing selections from session
        $selectedAdditionalAdvices = Session::get('selectedAdditionalAdvices', []);

        // Filter out the selected item by matching the ID
        $selectedAdditionalAdvices = array_filter($selectedAdditionalAdvices, function ($item) use ($id) {
            return $item['id'] != $id;
        });

        // Reindex the array to avoid issues with JavaScript handling
        $selectedAdditionalAdvices = array_values($selectedAdditionalAdvices);
        Session::put('selectedAdditionalAdvices', $selectedAdditionalAdvices);

        return $selectedAdditionalAdvices;
    }



}

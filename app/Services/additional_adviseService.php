<?php
namespace App\Services;
use App\Models\prescriptions\Aditional_advises;
use illuminate\Support\Facades\Auth;
class additional_adviseService{
    public function storeAdditionalAdviceData(array $data){
        $userId = Auth::id();
        $data['user_id'] = $userId;
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

}

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

}

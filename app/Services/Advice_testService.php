<?php

namespace App\Services;

use App\Models\prescriptions\advice_test;
use Illuminate\Support\Facades\Auth;

class Advice_testService{
    public function createTests(array $data){

        $userId = Auth::id();
        $data['user_id'] = $userId;
        return advice_test::create($data);

    }
    public function search(string $keyword){
        return advice_test::where('user_id', Auth::id())
        ->where('name','LIKE', "%{$keyword}%")
        ->get();
    }
    public function findAdviceTestByName(string $name){
        return advice_test::where('user_id', Auth::id())
        ->where('name', "%{$name}%")
        ->first();

    }
}

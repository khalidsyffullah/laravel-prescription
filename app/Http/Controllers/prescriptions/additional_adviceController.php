<?php

namespace App\Http\Controllers\prescriptions;

use App\Http\Controllers\Controller;
use App\Services\additional_adviseService;
use Illuminate\Http\Request;
use App\Http\Requests\prescriptions\additional_addviceRequest;

class additional_adviceController extends Controller
{
    protected $additional_adviseService;
    public function __construct(additional_adviseService $additionalAdvice) {
        $this->additional_adviseService = $additionalAdvice;

    }

    public function index(){
        return view('prescriptions.additional_advice.additional_advice');
    }

    public function store(additional_addviceRequest $request){
        $data = $request->validated();
        $additional_advice = $this->additional_adviseService->storeAdditionalAdviceData($data);

        return redirect()->back()->with('success','Data Added Successfully');

    }
}

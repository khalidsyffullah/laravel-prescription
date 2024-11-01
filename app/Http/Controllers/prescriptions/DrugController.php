<?php

namespace App\Http\Controllers\prescriptions;

use App\Http\Controllers\Controller;
use App\Http\Requests\prescriptions\DrugRequest;
use App\Services\DrugService;

class DrugController extends Controller
{
    protected $drug;
        public function __construct( DrugService $drug){
            $this->drug = $drug;

    }

    public function index(){
        return view('prescriptions.drugs');


    }
    public function store(DrugRequest $request) {
        try {
            $data = $request->validated(); // Fix typo in validated()
            $drug = $this->drug->createDrug($data);

            return redirect()->back()->with('success', 'Drug created successfully');
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create drug. Please try again.');
        }
    }
}

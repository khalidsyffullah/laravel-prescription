<?php

namespace App\Http\Controllers\prescriptions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\prescriptions\Advice_testsRequest;
use App\Services\Advice_testService;


class Advice_testsController extends Controller
{
    private $adviceTests;

    public function __construct(Advice_testService $adviceTests){

        $this->adviceTests = $adviceTests;

    }

    public function index(){

        return view('prescriptions.advice_tests.advice_tests');

    }

    public function store(Advice_testsRequest $requests){
        $data = $requests->validated();
        $advicedTests = $this->adviceTests->createTests($data);

        return redirect()->back()->with('success','data inserted successfully');

    }
}

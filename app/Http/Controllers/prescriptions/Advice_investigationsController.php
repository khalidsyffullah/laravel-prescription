<?php

namespace App\Http\Controllers\prescriptions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\advice_investigationRequest;
use App\Services\AdviceInvestigationService;

class Advice_investigationsController extends Controller
{
    protected $advice_investigationService;

    public function __construct(AdviceInvestigationService $advice_investigationService)
    {
        $this->advice_investigationService = $advice_investigationService;
    }
    public function index()
    {
        return view('prescriptions.advice_investigation.advice_investigation');
    }
    public function store(advice_investigationRequest $request)
    {
        $data = $request->validated();
        $adviceInvestigation = $this->advice_investigationService->createAdviceInvestigation($data);
        return redirect()->back()->with('success', value: 'Advice investigation created successfully.');



    }
}

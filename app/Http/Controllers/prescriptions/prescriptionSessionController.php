<?php

namespace App\Http\Controllers\prescriptions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\advice_investigationRequest;
use App\Http\Requests\prescriptions\additional_addviceRequest;
use App\Http\Requests\prescriptions\Advice_testsRequest;
use App\Http\Requests\prescriptions\DiagonosisRequest;
use App\Http\Requests\prescriptions\DrugRequest;
use App\Services\additional_adviseService;
use App\Services\Advice_testService;
use App\Services\AdviceInvestigationService;
use Illuminate\Support\Facades\Session;
use App\Services\DiagonosisService;
use App\Services\DrugService;

class prescriptionSessionController extends Controller
{
    protected $additionalAdviceService;
    protected $adviceTestService;
    protected $adviceInvestigationService;
    protected $diagonosisService;
    protected $drugService;

    public function __construct(
        additional_adviseService $additional_adviseService,
        Advice_testService $advice_testService,
        AdviceInvestigationService $adviceInvestigationService,
        DiagonosisService $diagonosisService,
        DrugService $drugService,

    ) {
        $this->additionalAdviceService = $additional_adviseService;
        $this->adviceTestService = $advice_testService;
        $this->adviceInvestigationService = $adviceInvestigationService;
        $this->diagonosisService = $diagonosisService;
        $this->drugService = $drugService;
    }
    private function checkItemInSession($sessionKey, $inputName)
    {
        $selectItems = Session::get($sessionKey, []);
        foreach ($selectItems as $selectItem) {
            if (strtolower($selectItem['name']) === strtolower($inputName)) {
                return response()->json(['exists' => true, $sessionKey => $selectItem]);
            }
        }
    }
    public function checkAdditionalAdviceInSession(Request $request){
        $name = $request->input('name');
        return $this->checkItemInSession('additionalAdvices','$name');

    }
    public function checkAdviceTestInSession(Request $request){
        $name = $request->input(key: 'name');
        return $this->checkItemInSession('adviceTests',$name);

    }
    public function checkAdviceInvestigationInSession(Request $request){
        $name = $request->input(key: 'name');
        return $this->checkItemInSession('adviceInvestigations',$name);


    }
    public function checkDiagnosisInSession(Request $request)
    {
        $name = $request->input('name');
        return $this->checkItemInSession('diagnoses',$name);

    }

    public function checkDrugInSession(Request $request){
        $name = $request->input(key: 'name');
        return $this->checkItemInSession('drugs',$name);


    }

    private function storeItemSelectionInSession($itemService, $storeItemSelectionInSession, $data, $sessionKey)
    {
        $selectItem = $itemService->$storeItemSelectionInSession($data);
        return response()->json(['success' => true, "{$sessionKey}" => $selectItem]);
    }

    public function storeAdditionalAdviceSelectionInSession(additional_addviceRequest $request)
    {
        $newSelection = $request->validated();
        return $this->storeItemSelectionInSession($this->additionalAdviceService, 'storeAdditionalAdviceSelectionInSession', data: $newSelection, sessionKey: 'selectedAdditionalAdvices');
    }

    public function storeAdviceTestsSelectionInSession(Advice_testsRequest $request)
    {
        $newSelection = $request->validated();
        return $this->storeItemSelectionInSession($this->adviceTestService, 'storeAdviceTestsSelectionInSession', data: $newSelection, sessionKey: 'selectedAdviceTests');
    }

    public function storeAdviceInvestigationSelectionInSession(advice_investigationRequest $request)
    {
        // Get validated data
        $newSelection = $request->validated();
        return $this->storeItemSelectionInSession($this->adviceInvestigationService, 'storeadviceInvestigationSelectionInSession', data: $newSelection, sessionKey: 'selectedAdviceInvestigations');
    }


    public function storeDiagonosisSelectionInSession(DiagonosisRequest $request)
    {
        $newSelection = $request->validated();
        return $this->storeItemSelectionInSession($this->diagonosisService, 'storeDiagonosisSelectionInSession', data: $newSelection, sessionKey: 'selectedDiagnoses');
    }

    public function storeDrugSelectionInSession(DrugRequest $request)
    {
        // Get validated data
        $newSelection = $request->validated();
        return $this->storeItemSelectionInSession($this->drugService, 'storeDrugSelectionInSession', data: $newSelection, sessionKey: 'selectedDrugs');
    }



    private function removeItemSelectionInSession($removeItemService, $removeItemSelectionInSession, $requestedId, $sessionKey)
    {
        $removeItem = $removeItemService->$removeItemSelectionInSession($requestedId);
        return response()->json(['success' => true, "{$sessionKey}" => $removeItem]);
    }


    public function removeAdditionalAdviceSelection(Request $request)
    {
        return $this->removeItemSelectionInSession($this->additionalAdviceService, 'removeAdditionalAdviceSelectionFromSession', $request->input('id'), 'selectedAdditionalAdvices');
    }

    public function removeAdviceTestsSelection(Request $request)
    {
        return $this->removeItemSelectionInSession($this->adviceTestService, 'removeAdviceTestsSelectionFromSession', $request->input('id'), 'selectedAdviceTests');
    }

    public function removeDiagonosisSelection(Request $request)
    {
        return $this->removeItemSelectionInSession($this->diagonosisService, 'removeDiagonosisSelectionFromSession', $request->input('id'), 'selectedDiagnoses');
    }

    public function removeAdviceInvestigationSelectionFromSession(Request $request)
    {
        return $this->removeItemSelectionInSession($this->adviceInvestigationService, 'removeAdviceInvestigationSelectionFromSession', $request->input('id'), 'selectedAdviceInvestigations');
    }

    public function removeDrugSelectionFromSession(Request $request)
    {
        return $this->removeItemSelectionInSession($this->drugService, 'removeDrugSelectionFromSession', $request->input('id'), 'selectedDrugs');
    }
}

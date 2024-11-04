<?php

namespace App\Http\Controllers\prescriptions;

use App\Http\Controllers\Controller;
use App\Http\Requests\advice_investigationRequest;
use App\Http\Requests\patientDetailsRequest;
use App\Http\Requests\prescriptions\additional_addviceRequest;
use App\Http\Requests\prescriptions\Advice_testsRequest;
use App\Http\Requests\prescriptions\DiagonosisRequest;
use App\Http\Requests\prescriptions\DrugRequest;
use Illuminate\Http\Request;
use App\Services\PrescriptionService;
use App\Services\DiagonosisService;
use App\Services\additional_adviseService;
use App\Services\Advice_testService;
use App\Services\AdviceInvestigationService;
use App\Services\DrugService;
use App\Services\PatientDetailService;

class PrescriptionController extends Controller
{
    protected $prescriptionService;
    protected $diagonosisService;
    protected $additionalAdviceService;
    protected $adviceInvestigationService;
    protected $adviceTestService;
    protected $drugService;
    protected $patientDetailService;

    public function __construct(
        PrescriptionService $prescriptionService,
        DiagonosisService $diagonosisService,
        additional_adviseService $additionalAdviceService,
        AdviceInvestigationService $adviceInvestigationService,
        Advice_testService $adviceTestService,
        DrugService $drugService,
        PatientDetailService $patientDetailService,
    ) {
        $this->prescriptionService = $prescriptionService;
        $this->diagonosisService = $diagonosisService;
        $this->additionalAdviceService = $additionalAdviceService;
        $this->adviceInvestigationService = $adviceInvestigationService;
        $this->adviceTestService = $adviceTestService;
        $this->drugService = $drugService;
        $this->patientDetailService = $patientDetailService;
    }

    public function index()
    {
        return view('prescriptions.prescriptions');
    }

    // Unified search method for both Diagonosis and Additional Advice
    private function searchItems($service, $keyword)
    {
        if (strlen($keyword) < 3) {
            return response()->json([]); // Return empty if keyword is less than 3 chars
        }

        // Call the service's search method
        $results = $service->search($keyword);

        return response()->json($results->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
            ];
        }));
    }

    public function searchDiagonosis(Request $request)
    {
        return $this->searchItems($this->diagonosisService, $request->input('keyword'));
    }

    public function searchAdditionalAdvice(Request $request)
    {
        return $this->searchItems($this->additionalAdviceService, $request->input('keyword'));
    }

    public function searchAdviceInvestigation(Request $request)
    {
        return $this->searchItems($this->adviceInvestigationService, $request->input('keyword'));
    }
    public function searchadviceTest(Request $request)
    {

        return $this->searchItems($this->adviceTestService, $request->input('keyword'));
    }
    public function searchdrug(Request $request)
    {

        return $this->searchItems($this->drugService, $request->input('keyword'));
    }
    public function searchpatientDetail(Request $request)
    {

        return $this->searchItems($this->patientDetailService, $request->input('keyword'));
    }



    // Unified store method for both Diagonosis and Additional Advice
    private function storeItem($service, $data, $checkMethod, $createMethod, $responseKey)
    {
        $existingItem = $service->$checkMethod($data['name']);

        if ($existingItem) {
            return response()->json(['exists' => true, $responseKey => $existingItem]);
        }

        $item = $service->$createMethod($data);

        return response()->json($item);
    }

    public function storeDiagonosis(DiagonosisRequest $request)
    {
        $data = $request->validated();
        return $this->storeItem($this->diagonosisService, $data, 'findDiagnosisByName', 'createDiagonosis', responseKey: 'diagnosis');
    }

    public function storeAdditionalAdvice(additional_addviceRequest $request)
    {
        $data = $request->validated();
        return $this->storeItem($this->additionalAdviceService, $data, 'findAdditionalAdviceServiceByName', 'storeAdditionalAdviceData', responseKey: 'additional_advice');
    }

    public function storeAdviceInvestigation(advice_investigationRequest $request)
    {
        $data = $request->validated();
        return $this->storeItem($this->adviceInvestigationService, $data, 'findAdviceInvestigationByName', 'createAdviceInvestigation', 'AdviceInvestigation');
    }
    public function storeAdviceTest(Advice_testsRequest $request)
    {
        $data = $request->validated();
        return $this->storeItem($this->adviceTestService, $data, 'findAdviceTestByName', 'createTests', 'adviceTest');
    }
    public function storeDrug(DrugRequest $request)
    {
        $data = $request->validated();
        return $this->storeItem($this->drugService, $data, 'findDrugByName', 'createDrug', 'drugs');
    }

    public function storePatientDetail(patientDetailsRequest $request)
    {
        $data = $request->validated();
        return $this->storeItem($this->patientDetailService, $data, 'findPatientByName', 'createPatient', 'Patients');
    }
}

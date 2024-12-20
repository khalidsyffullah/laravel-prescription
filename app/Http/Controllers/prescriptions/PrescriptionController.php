<?php

namespace App\Http\Controllers\prescriptions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\additional_adviseService;
use App\Services\Advice_testService;
use App\Services\AdviceInvestigationService;
use Illuminate\Support\Facades\Session;
use App\Services\DiagonosisService;
use App\Services\DrugService;


class PrescriptionController extends Controller
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

    public function index()
    {
        // Retrieve any previously stored selections from session
        $selectedAdditionalAdvices = Session::get('selectedAdditionalAdvices', []);
        $selectedAdviceTests = Session::get('selectedAdviceTests', []);
        $selectedAdviceInvestigations = Session::get('selectedAdviceInvestigations', []);
        $selectedDiagnoses = Session::get('selectedDiagnoses', []);
        $selectedDrugs = Session::get('selectedDrugs', []);
        // Pass selected diagnoses to the view
        return view('prescriptions.prescriptions', compact('selectedAdditionalAdvices', 'selectedAdviceTests', 'selectedAdviceInvestigations', 'selectedDiagnoses', 'selectedDrugs'));
    }

    private function itemSearch($itemService, $keyword, $searchItemKey)
    {
        $searchItems = $itemService->search($keyword);
        return response()->json(['success' => true, "{$searchItemKey}" => $searchItems]);
    }



    public function additionalAdviceSearch(Request $request)
    {
        $keyword = $request->input('keyword');
        return $this->itemSearch($this->additionalAdviceService, $keyword, 'additionalAdvice');
    }
    public function adviceTestSearch(Request $request)
    {
        $keyword = $request->input('keyword');
        return $this->itemSearch($this->adviceTestService, $keyword, 'adviceTest');
    }
    public function adviceInvestigationSearch(Request $request)
    {
        $keyword = $request->input('keyword');
        return $this->itemSearch($this->adviceInvestigationService, $keyword, 'adviceInvestigation');
    }

    public function diagonosisSearch(Request $request)
    {
        $keyword = $request->input('keyword');
        return $this->itemSearch($this->diagonosisService, $keyword, 'diagnosis');
    }

    public function drugSearch(Request $request)
    {
        $keyword = $request->input('keyword');
        return $this->itemSearch($this->drugService, $keyword, 'drug');
    }

    private function itemStore($itemStoreService, $createItems, $data, $itemKey)
    {
        $storeItems = $itemStoreService->$createItems($data);
        return response()->json(["{$itemKey}" => $storeItems]);
    }

    public function additionalAdviceStore(Request $request)
    {
        $data = ['name' => $request->input('name')];
        return $this->itemStore($this->additionalAdviceService, 'storeAdditionalAdviceData', $data, 'additionalAdvice');
    }

    public function adviceTestStore(Request $request)
    {
        $data = ['name' => $request->input('name')];
        return $this->itemStore($this->adviceTestService, 'createTests', $data, 'adviceTest');
    }

    public function adviceInvestigationStore(Request $request)
    {
        $data = ['name' => $request->input('name')];
        return $this->itemStore($this->adviceInvestigationService, 'createAdviceInvestigation', $data, 'adviceInvestigation');
    }

    public function diagonosisStore(Request $request)
    {
        $data = ['name' => $request->input('name')];
        return $this->itemStore($this->diagonosisService, 'createDiagonosis', $data, 'diagnosis');
    }

    public function drugStore(Request $request)
    {
        $data = ['name' => $request->input('name')];
        return $this->itemStore($this->drugService, 'createDrug', $data, 'drug');
    }
}

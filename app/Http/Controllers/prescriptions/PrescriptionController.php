<?php

namespace App\Http\Controllers\prescriptions;

use App\Http\Controllers\Controller;
use App\Http\Requests\prescriptions\additional_addviceRequest;
use App\Http\Requests\prescriptions\DiagonosisRequest;
use Illuminate\Http\Request;
use App\Services\PrescriptionService;
use App\Services\DiagonosisService;
use App\Services\additional_adviseService;

class PrescriptionController extends Controller
{
    protected $prescriptionService;
    protected $diagonosisService;
    protected $additionalAdviceService;

    public function __construct(
        PrescriptionService $prescriptionService,
        DiagonosisService $diagonosisService,
        additional_adviseService $additionalAdviceService
    ) {
        $this->prescriptionService = $prescriptionService;
        $this->diagonosisService = $diagonosisService;
        $this->additionalAdviceService = $additionalAdviceService;
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
        return $this->storeItem($this->diagonosisService, $data, 'findDiagnosisByName', 'createDiagonosis', 'diagnosis');
    }

    public function storeAdditionalAdvice(additional_addviceRequest $request)
    {
        $data = $request->validated();
        return $this->storeItem($this->additionalAdviceService, $data, 'findAdditionalAdviceServiceByName', 'storeAdditionalAdviceData', 'additional_advice');
    }
}

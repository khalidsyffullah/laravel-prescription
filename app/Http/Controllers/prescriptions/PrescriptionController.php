<?php

namespace App\Http\Controllers\prescriptions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PrescriptionService;
use App\Services\DiagonosisService;

class PrescriptionController extends Controller
{
    protected $prescriptionService;
    protected $diagonosisService;

    public function __construct(PrescriptionService $prescriptionService, DiagonosisService $diagonosisService)
    {
        $this->prescriptionService = $prescriptionService;
        $this->diagonosisService = $diagonosisService;
    }

    public function index()
    {
        return view('prescriptions.prescriptions');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        if (strlen($keyword) < 3) {
            return response()->json([]); // Return empty array if less than 3 characters
        }

        $results = $this->diagonosisService->searchDiagonosis($keyword);

        // Transform the results to include only the necessary fields
        return response()->json($results->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name
            ];
        }));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'descriptions' => 'nullable|string',
        ]);

        // Check if the diagnosis already exists
        $existingDiagnosis = $this->diagonosisService->findDiagnosisByName($data['name']);

        if ($existingDiagnosis) {
            return response()->json(['exists' => true, 'diagnosis' => $existingDiagnosis]);
        }

        $diagonosis = $this->diagonosisService->createDiagonosis($data);

        return response()->json($diagonosis);
    }
}

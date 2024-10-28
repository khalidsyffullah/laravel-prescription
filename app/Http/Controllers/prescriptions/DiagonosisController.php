<?php

namespace App\Http\Controllers\prescriptions;

use App\Http\Controllers\Controller;
use App\Services\DiagonosisService;
use App\Http\Requests\prescriptions\DiagonosisRequest;

class DiagonosisController extends Controller
{
    protected $diagonosisService;

    public function __construct(DiagonosisService $diagonosisService)
    {
        $this->diagonosisService = $diagonosisService;
    }

    public function index()
    {
        return view('prescriptions.diagonosis.diagonosis');
    }

    public function store(DiagonosisRequest $request)
    {
        $data = $request->validated();
        $diagonosis = $this->diagonosisService->createDiagonosis($data);
        return redirect()->back()->with('success', 'Diagonosis created successfully.');
    }
}

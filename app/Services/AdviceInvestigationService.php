<?php

namespace App\Services;

use App\Models\prescriptions\Advise_investigation;
use Illuminate\Support\Facades\Auth;

class AdviceInvestigationService
{
    public function createAdviceInvestigation(array $data)
    {
        $userId = Auth::id();
        $data['user_id'] = $userId;
        return Advise_investigation::create($data);

    }
}

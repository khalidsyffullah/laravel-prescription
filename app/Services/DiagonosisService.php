<?php

namespace App\Services;

use App\Models\prescriptions\Diagonosis;
use Illuminate\Support\Facades\Auth;

class DiagonosisService
{
    public function createDiagonosis(array $data)
    {
        $userId = Auth::id();
        $data['user_id'] = $userId;
        return Diagonosis::create($data);
    }
}


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

    public function searchDiagonosis(string $keyword)
    {
        return Diagonosis::where('user_id', Auth::id())
            ->where('name', 'LIKE', "%{$keyword}%")
            ->get();
    }

    public function findDiagnosisByName(string $name)
    {
        return Diagonosis::where('user_id', Auth::id())
            ->where('name', $name)
            ->first(); // Return the first matching record or null
    }
}


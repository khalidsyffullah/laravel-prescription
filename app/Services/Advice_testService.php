<?php

namespace App\Services;

use App\Models\prescriptions\advice_test;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class Advice_testService
{
    public function createTests(array $data)
    {

        $userId = Auth::id();
        $data['user_id'] = $userId;
        $extstingAdviceTests = advice_test::where('user_id', $userId)
            ->where('name', $data['name'])
            ->first();
        if ($extstingAdviceTests) {
            return $extstingAdviceTests;
        }
        return advice_test::create($data);
    }
    public function search(string $keyword)
    {
        return advice_test::where('user_id', Auth::id())
            ->where('name', 'LIKE', "%{$keyword}%")
            ->get();
    }
    public function findAdviceTestByName(string $name)
    {
        return advice_test::where('user_id', Auth::id())
            ->where('name', "%{$name}%")
            ->first();
    }

    public function storeAdviceTestsSelectionInSession(array $newSelection)
    {
        // Retrieve existing selections from session
        $selectedAdviceTests = Session::get('selectedAdviceTests', []);

        // Check if the new selection is already in the session
        if (!in_array($newSelection, $selectedAdviceTests)) {
            $selectedAdviceTests[] = $newSelection; // Add only if not already present
            Session::put('selectedAdviceTests', $selectedAdviceTests); // Update the session
        }

        return $selectedAdviceTests;
    }


    public function removeAdviceTestsSelectionFromSession(int $id)
    {
        // Retrieve existing selections from session
        $selectedAdviceTests = Session::get('selectedAdviceTests', []);

        // Filter out the selected item by matching the ID
        $selectedAdviceTests = array_filter($selectedAdviceTests, function ($item) use ($id) {
            return $item['id'] != $id;
        });

        // Reindex the array to avoid issues with JavaScript handling
        $selectedAdviceTests = array_values($selectedAdviceTests);
        Session::put('selectedAdviceTests', $selectedAdviceTests);

        return $selectedAdviceTests;
    }
}

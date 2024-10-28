<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\LoginService;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        // Attempt login through the service
        $result = $this->loginService->attemptLogin($request->only('email_or_phone', 'password'));

        if ($result === true) {
            return redirect()->route('doctor.dashboard');
        } elseif ($result === 'inactive') {
            return back()->withErrors(['inactive' => 'Your account is inactive. Please contact support.']);
        }

        return back()->withErrors(['login' => 'Invalid credentials. Please try again.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}

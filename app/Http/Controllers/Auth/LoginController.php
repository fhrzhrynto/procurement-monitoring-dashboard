<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers {
        attemptLogin as attemptLoginFromTrait;
        logout as logoutFromTrait;
    }

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') && 
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->credentials($request);
        $remember = $request->boolean('remember');

        Log::info("Login attempt for {$request->email} with remember: " . ($remember ? 'YES' : 'NO'));

        if (Auth::attempt($credentials, $remember)) {
            if ($request->hasSession()) {
                $request->session()->regenerate();
            }

            $loggedUser = Auth::user();
            Log::info("Login successful. Remember token: " . 
                ($loggedUser->remember_token ? substr($loggedUser->remember_token, 0, 10) . "..." : 'NULL'));

            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);
        $remember = $request->boolean('remember');

        Log::info('Login attempt with Remember: ' . ($remember ? 'YES' : 'NO'));

        return $this->guard()->attempt($credentials, $remember);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            Log::info('User logging out: ' . $user->email);
            Log::info('Remember token before logout: ' . ($user->remember_token ? 'EXISTS' : 'NULL'));
        }

        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('User logged out successfully');

        return redirect('/');
    }

    protected function guard()
    {
        return Auth::guard('web');
    }
}

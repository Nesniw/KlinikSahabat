<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Http\Middleware\CheckUserRole;
use Carbon\Carbon;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('pages.login');
    }


    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();
    
            $request->session()->regenerate();
    
            Auth::guard('pekerja')->logout();
    
            Auth::user()->update(['terakhir_login' => now('Asia/Jakarta')]);
    
            return redirect()->intended(RouteServiceProvider::HOME);

        } catch (ValidationException $e) {
            // Handle failed login attempt
            return redirect()->route('login')->with('failed', 'Login gagal. Cek kembali email atau password Anda.');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

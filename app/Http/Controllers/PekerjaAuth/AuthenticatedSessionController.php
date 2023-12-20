<?php

namespace App\Http\Controllers\PekerjaAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PekerjaAuth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Carbon\Carbon;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('pekerja.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        Auth::guard('web')->logout();

        $pekerja = Auth::guard('pekerja')->user();

        if ($pekerja) {
            $pekerja->update(['terakhir_login' => Carbon::now('Asia/Jakarta')]);
        }

        return redirect()->intended(RouteServiceProvider::PEKERJA_HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('pekerja')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

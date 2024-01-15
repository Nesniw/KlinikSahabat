<?php

namespace App\Http\Controllers\PekerjaAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PekerjaAuth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
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
        try {
            $request->authenticate();

            $request->session()->regenerate();

            Auth::guard('web')->logout();

            $pekerja = Auth::guard('pekerja')->user();

            if ($pekerja) {
                $pekerja->update(['terakhir_login' => Carbon::now('Asia/Jakarta')]);

                if ($pekerja->peran === 'Dokter') {
                    // Jika peran Dokter, redirect ke rute yang sesuai
                    return redirect()->intended(RouteServiceProvider::DOKTER_HOME);
                }

                else if ($pekerja->peran === 'Groomer') {
                    // Jika peran Dokter, redirect ke rute yang sesuai
                    return redirect()->intended(RouteServiceProvider::GROOMER_HOME);
                }
            }

            return redirect()->intended(RouteServiceProvider::PEKERJA_HOME);

        } catch (ValidationException $e) {
            // Handle failed login attempt
            return redirect()->route('pekerja.login')->with('failed', 'Login gagal. Cek kembali email atau password Anda.');
        }
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

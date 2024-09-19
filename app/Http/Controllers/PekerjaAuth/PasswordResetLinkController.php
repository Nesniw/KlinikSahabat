<?php

namespace App\Http\Controllers\PekerjaAuth;

use App\Http\Controllers\Controller;
use App\Models\Pekerja;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('pekerja.forgot-password-pekerja');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);
    
        // Cek apakah email ada di tabel Pekerja
        $pekerja = Pekerja::where('email', $request->email)->first();
    
        // Jika tidak ada, kembalikan pesan kesalahan
        if (!$pekerja) {
            return back()->withErrors(['email' => __('Email yang Anda masukkan tidak terdaftar')]);
        }
    
        // Email ada di tabel Pekerja, lanjutkan proses pengiriman reset link
        $status = Password::broker('pekerja')->sendResetLink(
            $request->only('email')
        );
    
        // Tampilkan pesan sesuai status pengiriman reset link
        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }
}

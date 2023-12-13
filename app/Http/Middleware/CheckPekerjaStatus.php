<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPekerjaStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $pekerja = Auth::guard('pekerja')->user();

        if ($pekerja && $pekerja->status === 'Nonaktif') {
            // Jika status pekerja nonaktif, logout dan redirect ke halaman login
            Auth::guard('pekerja')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('pekerja.login')->with('failed', 'Akun Anda telah dinonaktifkan.');
        }

        return $next($request);
    }

}

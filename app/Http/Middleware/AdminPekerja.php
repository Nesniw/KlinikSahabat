<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminPekerja
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $pekerja = $request->user('pekerja');

        if ($pekerja && $pekerja->peran === 'Admin') {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki akses.');
    }
}

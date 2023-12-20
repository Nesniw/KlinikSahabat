<?php

namespace App\Http\Middleware;

use Closure;

class PreventBackHistory
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
        // Check if the session variable exists
        if ($request->session()->has('preventBackHistory')) {
            // Remove the session variable to allow normal navigation after redirect
            $request->session()->forget('preventBackHistory');

            // Perform the redirect to the home page or any other desired URL
            return redirect('/'); // Change '/' to the desired URL
        }

        $response = $next($request);

        return $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');

    }
}

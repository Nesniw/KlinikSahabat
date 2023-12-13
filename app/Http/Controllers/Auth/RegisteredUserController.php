<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('pages.registration');
    }

    /**
     * Handle an incoming registration request.
     * 
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try{
            \Log::info($request->all());

            $request->validate([
                'namalengkap' => ['required', 'string', 'max:255'],
                'jeniskelamin' => ['required', 'string'],
                'tanggallahir' => ['required', 'date'],
                'alamat' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
                'nomortelepon' => ['required', 'string', 'max:14'],
                'password' => ['required', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'namalengkap' => $request->namalengkap,
                'jeniskelamin' => $request->jeniskelamin,
                'tanggallahir' => $request->tanggallahir,
                'alamat' => $request->alamat,
                'email' => $request->email,
                'nomortelepon' => $request->nomortelepon,
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));

            Auth::login($user);

            return redirect(RouteServiceProvider::HOME);
        }
        catch (\Exception $e) {
            return back()->with('failed', 'Gagal membuat akun');
        }
    }
}

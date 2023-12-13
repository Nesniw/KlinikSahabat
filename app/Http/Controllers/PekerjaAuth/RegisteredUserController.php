<?php

namespace App\Http\Controllers\PekerjaAuth;

use App\Http\Controllers\Controller;
use App\Models\Pekerja;
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
        return view('pekerja.auth.registration');
    }

    /**
     * Handle an incoming registration request.
     * 
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        
        \Log::info($request->all());

        $request->validate([
            'pekerja_id' => ['required', 'string', 'unique:pekerja'],
            'namapekerja' => ['required', 'string', 'max:255'],
            'peran' => ['required', 'string'],
            'jeniskelamin' => ['required', 'string'],
            'tanggallahir' => ['required', 'date'],
            'alamat' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Pekerja::class],
            'nomortelepon' => ['required', 'string', 'max:14'],
            'foto' => ['image|mimes:jpeg,png,jpg,gif|max:2048'], 
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_pekerja', 'public');
        } else {
            $fotoPath = null;
        }

        $pekerja = Pekerja::create([
            'pekerja_id' => $request->pekerja_id,
            'namapekerja' => $request->namapekerja,
            'peran' => $request->peran,
            'jeniskelamin' => $request->jeniskelamin,
            'tanggallahir' => $request->tanggallahir,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'nomortelepon' => $request->nomortelepon,
            'foto' => $fotoPath,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($pekerja));

        Auth::guard('pekerja')->login($pekerja);

        return redirect(RouteServiceProvider::PEKERJA_HOME);
    }
}

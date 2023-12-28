<?php

namespace App\Http\Controllers;

use App\Http\Requests\PekerjaProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfilePekerjaController extends Controller
{
    /**
     * Display the user's profile form.
     */
    
     public function view(): View
    {
        $pekerja = Auth::guard('pekerja')->user();

        $title = 'Profile Pekerja';

        return view('pekerja.profile-pekerja', [
            'pekerja' => $pekerja,
            'title' => $title,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(PekerjaProfileUpdateRequest $request): RedirectResponse
    {
        try {
            \Log::info($request->all());

            $pekerja = Auth::guard('pekerja')->user();

            $imagePath = $pekerja->foto;
            
            \Log::info($imagePath);

            if ($request->hasFile('foto')) {
                // If a new image is uploaded, delete the old image
                Storage::delete('public/'.$pekerja->foto);
    
                // Save the new image in the 'pekerja_images' folder
                $imagePath = $request->file('foto')->store('pekerja_images', 'public');
            }
            
            $pekerja->fill($request->validated());

            if ($pekerja->isDirty('email')) {
                $pekerja->email_verified_at = null;
            }

            $pekerja->foto = $imagePath;

            $pekerja->save();

            return Redirect::route('viewProfilePekerja')->with('success', 'Profile berhasil diperbarui');
        } 
        catch (\Exception $e) {

            return back()->with('failed', 'Profile gagal diperbarui');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

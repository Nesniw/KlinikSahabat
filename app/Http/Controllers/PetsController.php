<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Pets;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PetsController extends Controller
{
    //
    public function viewPets()
    {
        $userPets = Auth::user()->pets()->with('RekamMedis')->orderBy('namapasien')->get();

        $title = 'My Pets';

        return view('mypets.pets', compact('title', 'userPets'));
    }

    public function showRekamMedis($kode_pasien)
    {
        $userPet = Pets::where('kode_pasien', $kode_pasien)->first();
        
        $rekamMedis = $userPet->RekamMedis;
        
        $title = 'Rekam Medis Pets';

        return view('mypets.rekam-medis', compact('title', 'rekamMedis', 'userPet'));
    }

    public function createRandomCode()
    {
        $title = 'Tambah Pet';

        $randomCode = strtoupper(Str::random(6));
        $user = Auth::user();
        $user_id = $user->user_id;
        return view('mypets.registerPets',compact(['title', 'randomCode', 'user_id', 'user']));
    }

    public function storePet(Request $request)
    {

        \Log::info($request->all());

        try {
            $request->validate([
                'kode_pasien' => ['required', 'unique:pets'],
                'namapasien' => ['required', 'string', 'max:255'],
                'jenishewan' => ['required', 'string'],
                'ras' => ['required', 'string', 'max:255'],
                'jeniskelamin' => ['required', 'string'],
                'umur_tahun' => ['required', 'string', 'max:255'],
                'umur_bulan' => ['required', 'string', 'max:255'],
                'berat' => ['required', 'string', 'max:255'],
                'tipedarah' => ['nullable', 'string', 'max:255'],
                'alergi' => ['nullable', 'string', 'max:255'],
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
            ]);

            $imagePath = null;
            
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('pets_images', 'public');
            } else {
                $imagePath = null;
            }

            $user = Auth::user();

            // Simpan data hewan peliharaan ke database
            $pet = new Pets([
                'kode_pasien' => $request->kode_pasien,
                'namapasien' => $request->namapasien,
                'jenishewan' => $request->jenishewan,
                'ras' => $request->ras,
                'jeniskelamin' => $request->jeniskelamin,
                'umur_tahun' => $request->umur_tahun,
                'umur_bulan' => $request->umur_bulan,
                'berat' => $request->berat,
                'tipedarah' => $request->tipedarah,
                'alergi' => $request->alergi,
                'image' => $imagePath,
                'user_id' => $user->id, 
            ]);

            $user->pets()->save($pet);

            // Salah satu cara lain buat create data ke database
            // $pet = [
            //     'kode_pasien' => $request->kode_pasien,
            //     'namapasien' => $request->namapasien,
            //     // ... (isi data lainnya)
            //     'image' => $imagePath,
            // ];
        
            // $user->pets()->create($pet);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        return redirect()->route('viewPets')->with('success', 'Pet added successfully!');
    }

    public function updatePetForm($kode_pasien)
    {
        $pet = Pets::findOrFail($kode_pasien);
        $title = 'Ubah Data Pet';

        return view('mypets.updatePets', compact('title', 'pet'));
    }

    public function updatePet(Request $request, $kode_pasien)
    {
        try {
            $pet = Pets::findOrFail($kode_pasien);

            $request->validate([
                'namapasien' => ['required', 'string', 'max:255'],
                'jenishewan' => ['required', 'string'],
                'ras' => ['required', 'string', 'max:255'],
                'jeniskelamin' => ['required', 'string'],
                'umur_tahun' => ['required', 'string', 'max:255'],
                'umur_bulan' => ['required', 'string', 'max:255'],
                'berat' => ['required', 'string', 'max:255'],
                'tipedarah' => ['nullable', 'string', 'max:255'],
                'alergi' => ['nullable', 'string', 'max:255'],
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $imagePath = $pet->image; // Tetap gunakan path gambar lama jika tidak ada gambar baru diupload

            if ($request->hasFile('image')) {
                // Jika ada gambar baru diupload, hapus gambar lama
                Storage::delete('public/'.$pet->image);

                // Simpan gambar baru dan update path
                $imagePath = $request->file('image')->store('pets_images', 'public');
            }
            
            // Update data hewan peliharaan
            $pet->update([
                'namapasien' => $request->namapasien,
                'jenishewan' => $request->jenishewan,
                'ras' => $request->ras,
                'jeniskelamin' => $request->jeniskelamin,
                'umur_tahun' => $request->umur_tahun,
                'umur_bulan' => $request->umur_bulan,
                'berat' => $request->berat,
                'tipedarah' => $request->tipedarah,
                'alergi' => $request->alergi,
                'image' => $imagePath,
            ]);


        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        return redirect()->route('viewPets')->with('success', 'Pet updated successfully!');
    }

    public function nonaktifkanPet(Request $request, $kode_pasien)
    {
        $pet = Pets::findOrFail($kode_pasien);

        $pet->update([
            'status' => 'Nonaktif',
            'alasan_nonaktif' => $request->input('alasan_nonaktif'),
        ]);

        return redirect()->route('viewPets')->with('success', 'Berhasil menonaktifkan hewan peliharaan!');
    }

    public function aktifkanPet(Request $request, $kode_pasien)
    {
        $pet = Pets::findOrFail($kode_pasien);

        $pet->update([
            'status' => 'Aktif',
            'alasan_nonaktif' => null,
        ]);

        return redirect()->route('viewPets')->with('success', 'Berhasil mengaktifkan hewan peliharaan!');
    }

    public function deletePet($kode_pasien)
    {
        try {
            $pet = Pets::findOrFail($kode_pasien);
            Storage::delete('public/'.$pet->image);
            $pet->delete();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        return redirect()->route('viewPets')->with('success', 'Pet deleted successfully!');
    }
}

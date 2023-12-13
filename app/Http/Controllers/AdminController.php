<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pets;
use App\Models\User;
use App\Models\Pekerja;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class AdminController extends Controller
{
    //
    // public function displayUser()
    // {
    //     $data = User::all();
    //     return view('admin.data-user',compact(['data']));
    // }

    public function displayUser(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select(['user_id', 'namalengkap', 'jeniskelamin', 'tanggallahir', 'alamat', 'email', 'nomortelepon']);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($user){
                        
                        $deleteUrl = route('DeleteUserData', $user->user_id);
                        $editUrl = route('UpdateUserForm', ['user_id' => $user->user_id]);
     
                        $actionBtn = '
                            <a href="' . $editUrl . '" class="edit btn btn-success btn-sm mb-2"><i class="fas fa-edit"></i> Update</a>';

                        $actionBtn .= '
                            <form action="' . $deleteUrl . '" method="POST" class="d-inline">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="delete btn btn-danger btn-sm"><i class="fas fa-trash"></i>  Delete</button>
                            </form>';
    
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.data-user');
    }

    public function CreateUserForm()
    {
        return view('admin.create-user');
    }
    
    public function CreateUser(Request $request): RedirectResponse
    {
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

        $user->save();

        return redirect()->route('ShowUserData')->with('success', 'User Berhasil Ditambahkan!');
    }

    public function deleteUser($user_id)
    {
        $user = User::findOrFail($user_id);
        $user->delete();

        return redirect()->route('ShowUserData')->with('success', 'Berhasil menghapus Data User!');;
    }

    public function UpdateUserForm($user_id)
    {
        $user = User::findOrFail($user_id);
        return view('admin.update-user', compact('user'));
    }

    public function updateUser(Request $request, $user_id): RedirectResponse
    {
        $request->validate([
            'namalengkap' => ['required', 'string', 'max:255'],
            'jeniskelamin' => ['required', 'string'],
            'tanggallahir' => ['required', 'date'],
            'alamat' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class.',email,'.$user_id],
            'nomortelepon' => ['required', 'string', 'max:14'],
        ]);

        $user = User::findOrFail($user_id);
        $user->update([
            'namalengkap' => $request->namalengkap,
            'jeniskelamin' => $request->jeniskelamin,
            'tanggallahir' => $request->tanggallahir,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'nomortelepon' => $request->nomortelepon,
        ]);

        return redirect()->route('ShowUserData')->with('success', 'Berhasil Memperbarui Data User!');
    }


    public function displayPasien(Request $request)
    {
        if ($request->ajax()) {
            $data = Pets::select([
                'kode_pasien',
                'namapasien', 
                'jenishewan',
                'ras',
                'jeniskelamin',
                'umur_tahun',
                'umur_bulan',
                'berat',
                'tipedarah',
                'alergi',
                'image',
                'user_id',
            ]);

            return Datatables::of($data)    
                    ->addIndexColumn()
                    ->addColumn('nama_pemilik', function ($pet) {
                        // Jika model Pet memiliki relasi dengan User, gunakan relasi ini untuk mendapatkan nama pemilik.
                        return $pet->user->namalengkap;
                    })
                    ->addColumn('image', function ($pet) {
                        $imageUrl = asset('storage/pets_images/' . basename($pet->image));
                        return '<img src="' . $imageUrl . '" alt="Pet Image" width="50">';
                    })
                    ->editColumn('tipedarah', function ($pet) {
                        return $pet->tipedarah ?? '-';
                    })
                    ->editColumn('alergi', function ($pet) {
                        return $pet->alergi ?? '-';
                    })
                    ->addColumn('action', function ($pet) {
                        return '<button class="btn btn-primary">Detail</button>';
                    })
                    ->rawColumns(['image','action'])
                    ->make(true);
        }
        
        return view('admin.data-pasien');
    }

    public function displayPekerja(Request $request)
    {
        if ($request->ajax()) {
            $data = Pekerja::select([
                'pekerja_id',
                'namapekerja', 
                'peran',
                'jeniskelamin',
                'tanggallahir',
                'alamat',
                'nomortelepon',
                'email',
                'foto',
            ]);

            return Datatables::of($data)    
                    ->addIndexColumn()
                    ->addColumn('foto', function ($pekerja) {
                        $imageUrl = asset('storage/pekerja_images/' . basename($pekerja->foto));
                        return '<img src="' . $imageUrl . '" alt="Image Pekerja" width="50">';
                    })
                    ->addColumn('action', function($pekerja){
                        
                        $deleteUrl = route('DeletePekerjaData', $pekerja->pekerja_id);
                        $editUrl = route('UpdatePekerjaForm', ['pekerja_id' => $pekerja->pekerja_id]);
                        $nonAktifUrl = route('NonaktifPekerja', ['pekerja_id' => $pekerja->pekerja_id]);

                        $actionBtn = '
                            <a href="' . $editUrl . '" class="edit btn btn-success btn-sm mb-2"><i class="fas fa-edit"></i> Update</a>';

                        $actionBtn .= '
                            <form action="' . $deleteUrl . '" method="POST" class="d-inline">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="delete btn btn-danger btn-sm"><i class="fas fa-trash"></i>  Delete</button>
                            </form>';
    
                        return $actionBtn;
                    })
                    ->rawColumns(['foto','action'])
                    ->make(true);
        }
        
        return view('admin.data-pekerja');
    }

    public function CreatePekerjaForm()
    {
        return view('admin.create-pekerja');
    }

    public function CreatePekerja(Request $request): RedirectResponse
    {
        try {
            \Log::info($request->all());

            $request->validate([
                'pekerja_id' => ['required', 'string', 'max:10'],
                'namapekerja' => ['required', 'string', 'max:255'],
                'peran' => ['required', 'string'],
                'jeniskelamin' => ['required', 'string'],
                'tanggallahir' => ['required', 'date'],
                'alamat' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Pekerja::class],
                'nomortelepon' => ['required', 'string', 'max:14'],
                'password' => ['required', Rules\Password::defaults()],
                'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
            ]);

            $fotoPath = null;
            
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('pekerja_images', 'public');
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
                'password' => Hash::make($request->password),
                'foto' => $fotoPath,
            ]);

            $pekerja->save();

            return redirect()->route('ShowPekerjaData')->with('success', 'Akun Pekerja Berhasil Ditambahkan!');
        }
        catch (\Exception $e) {
            dd($e->getMessage());
            
        }
    }

    public function updatePekerjaForm($pekerja_id)
    {
        $pekerja = Pekerja::findOrFail($pekerja_id);
        return view('admin.update-pekerja', compact('pekerja'));
    }

    public function updatePekerja(Request $request, $pekerja_id): RedirectResponse
    {
        try {
            $pekerja = Pekerja::findOrFail($pekerja_id);

            $request->validate([
                'pekerja_id' => ['required', 'string', 'max:10'],
                'namapekerja' => ['required', 'string', 'max:255'],
                'peran' => ['required', 'string'],
                'jeniskelamin' => ['required', 'string'],
                'tanggallahir' => ['required', 'date'],
                'alamat' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Pekerja::class.',email,'.$pekerja_id],
                'nomortelepon' => ['required', 'string', 'max:14'],
                'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $fotoPath = $pekerja->foto; // Tetap gunakan path gambar lama jika tidak ada gambar baru diupload

            if ($request->hasFile('foto')) {
                // Jika ada gambar baru diupload, hapus gambar lama
                Storage::delete('public/'.$pekerja->foto);

                // Simpan gambar baru dan update path
                $fotoPath = $request->file('foto')->store('pekerja_images', 'public');
            }

            $pekerja->update([
                'pekerja_id' => $request->pekerja_id,
                'namapekerja' => $request->namapekerja,
                'peran' => $request->peran,
                'jeniskelamin' => $request->jeniskelamin,
                'tanggallahir' => $request->tanggallahir,
                'alamat' => $request->alamat,
                'email' => $request->email,
                'nomortelepon' => $request->nomortelepon,
                'foto' => $fotoPath,
            ]);

            return redirect()->route('ShowPekerjaData')->with('success', 'Berhasil Memperbarui Data Pekerja!');
        }
        catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function deletePekerja($pekerja_id)
    {
        $pekerja = Pekerja::findOrFail($pekerja_id);
        $pekerja->delete();

        return redirect()->route('ShowPekerjaData')->with('success', 'Data Pekerja Berhasil Dihapus!');;
    }

    public function nonaktifkanPekerja($pekerja_id)
    {
        $pekerja = Pekerja::findOrFail($pekerja_id);

        // Toggle status dan waktu nonaktif berdasarkan status sebelumnya
        if ($pekerja->status === 'Aktif') {
            $pekerja->status = 'Nonaktif';
            $pekerja->nonaktif_at = now();
        } else {
            $pekerja->status = 'Aktif';
            $pekerja->nonaktif_at = null;
        }

        $pekerja->save();

        return redirect()->route('ShowPekerjaData')->with('success', 'Status akun pekerja diperbarui.');
    }

    public function hapusPekerja($pekerja_id)
    {
        $pekerja = Pekerja::findOrFail($pekerja_id);

        // Hapus hanya jika sudah lebih dari 30 hari nonaktif
        if ($pekerja->nonaktif_at && $pekerja->nonaktif_at->diffInDays(now()) > 30) {
            $pekerja->delete();
            return redirect()->route('ShowPekerjaData')->with('success', 'Akun pekerja dihapus.');
        } else {
            return redirect()->route('ShowPekerjaData')->with('failed', 'Akun pekerja belum dapat dihapus.');
        }
    }
    
}

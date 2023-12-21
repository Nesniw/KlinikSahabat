<?php

namespace App\Http\Controllers;

use App\Http\Requests\PekerjaProfileUpdateRequest;
use App\Notifications\PaymentConfirmedNotification;
use App\Notifications\PaymentRejectedNotification;
use App\Models\JadwalClinic;
use App\Models\JadwalKlinik;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\Pets;
use App\Models\User;
use App\Models\Pekerja;
use App\Models\KategoriLayanan;
use App\Models\Layanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Schema;

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
        Storage::delete('public/'.$pekerja->foto);
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
    
    public function displayKategori(Request $request)
    {
        if ($request->ajax()) {
            $data = KategoriLayanan::select(['kategori_layanan_id', 'nama_kategori', 'deskripsi_kategori']);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($kategori){
                        
                        $deleteUrl = route('DeleteKategoriData', $kategori->kategori_layanan_id);
                        $editUrl = route('UpdateKategoriForm', ['kategori_layanan_id' => $kategori->kategori_layanan_id]);
     
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
        
        return view('admin.data-kategori');
    }

    public function CreateKategoriForm()
    {
        return view('admin.create-kategori');
    }
    
    public function CreateKategori(Request $request): RedirectResponse
    {
        \Log::info($request->all());

        $request->validate([
            'nama_kategori' => ['required', 'string'],
            'deskripsi_kategori' => ['required', 'string'],
        ]);

        $kategori = KategoriLayanan::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi_kategori' => $request->deskripsi_kategori,
        ]);

        $kategori->save();

        return redirect()->route('ShowKategoriData')->with('success', 'Kategori Berhasil Ditambahkan!');
    }

    public function updateKategoriForm($kategori_layanan_id)
    {
        $kategori = KategoriLayanan::findOrFail($kategori_layanan_id);

        // Mengcek apakah kategori_layanan_id terkait ada di tabel layanan
        $isForeignKey = Layanan::where('kategori_layanan_id', $kategori_layanan_id)->exists();
    
        return view('admin.update-kategori', compact('kategori', 'isForeignKey'));
    }


    public function updateKategori(Request $request, $kategori_layanan_id): RedirectResponse
    {
        $kategori = KategoriLayanan::findOrFail($kategori_layanan_id);

        $request->validate([
            'nama_kategori' => ['required', 'string'],
            'deskripsi_kategori' => ['required', 'string'],
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi_kategori' => $request->deskripsi_kategori,
        ]);

        return redirect()->route('ShowKategoriData')->with('success', 'Berhasil Memperbarui Data Kategori!');
    }

    public function deleteKategori($kategori_layanan_id)
    {
        $kategori = KategoriLayanan::findOrFail($kategori_layanan_id);
        $kategori->delete();

        return redirect()->route('ShowKategoriData')->with('success', 'Berhasil menghapus Data Kategori!');;
    }

    public function displayLayanan(Request $request)
    {
        if ($request->ajax()) {
            $data = Layanan::select(['layanan_id', 'nama_layanan', 'biaya_booking', 'harga_layanan', 'deskripsi_layanan', 'kategori_layanan_id']);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nama_kategori', function ($layanan) {
                        // Jika model Pet memiliki relasi dengan User, gunakan relasi ini untuk mendapatkan nama pemilik.
                        return $layanan->KategoriLayanan->nama_kategori;
                    })
                    ->addColumn('action', function($layanan){
                        
                        $deleteUrl = route('DeleteLayananData', $layanan->layanan_id);
                        $editUrl = route('UpdateLayananForm', ['layanan_id' => $layanan->layanan_id]);
     
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
        
        return view('admin.data-layanan');
    }

    public function CreateLayananForm()
    {
        $kategori = KategoriLayanan::all();
        return view('admin.create-layanan', compact('kategori') );
    }
    
    public function CreateLayanan(Request $request): RedirectResponse
    {
        try {
            \Log::info($request->all());

            $request->validate([
                'kategori_layanan_id' => ['required', 'string'],
                'nama_layanan' => ['required', 'string'],
                'biaya_booking' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
                'harga_layanan' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
                'deskripsi_layanan' => ['required', 'string'],
            ]);

            // Cari kategori_layanan_id berdasarkan nama_kategori
            // $kategori = KategoriLayanan::where('nama_kategori', $request->nama_kategori)->firstOrFail();

            $layanan = Layanan::create([
                'kategori_layanan_id' => $request->kategori_layanan_id,
                'nama_layanan' => $request->nama_layanan,
                'biaya_booking' => $request->biaya_booking,
                'harga_layanan' => $request->harga_layanan,
                'deskripsi_layanan' => $request->deskripsi_layanan,
            ]);

            $layanan->save();

            return redirect()->route('ShowLayananData')->with('success', 'Layanan Berhasil Ditambahkan!');
        }
        catch (\Exception $e) {
            dd($e->getMessage());
            
        }

    }

    public function updateLayananForm($layanan_id)
    {
        $layanan = Layanan::findOrFail($layanan_id);
        $kategori = KategoriLayanan::all();

        $NamaKategori = KategoriLayanan::where('kategori_layanan_id', $layanan->kategori_layanan_id)->value('nama_kategori');
    
        return view('admin.update-layanan', compact('layanan', 'kategori', 'NamaKategori'));
    }


    public function updateLayanan(Request $request, $layanan_id): RedirectResponse
    {
        $layanan = Layanan::findOrFail($layanan_id);

        $request->validate([
            'kategori_layanan_id' => ['required', 'string', 'max:10'],
            'nama_layanan' => ['required', 'string'],
            'biaya_booking' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'harga_layanan' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'deskripsi_layanan' => ['required', 'string'],
        ]);


        $layanan->update([
            'kategori_layanan_id' => $request->kategori_layanan_id,
            'nama_layanan' => $request->nama_layanan,
            'biaya_booking' => $request->biaya_booking,
            'harga_layanan' => $request->harga_layanan,
            'deskripsi_layanan' => $request->deskripsi_layanan,
        ]);

        return redirect()->route('ShowLayananData')->with('success', 'Berhasil Memperbarui Data Layanan!');
    }

    // private function generateNewLayananId($kategoriLayananId)
    // {
    //     // Logika Anda untuk membuat layanan_id baru berdasarkan kategori_layanan_id
    //     // Misalnya, Anda dapat mengambil data dari database untuk menentukan nomor urut terakhir
    //     // Kemudian menambahkannya satu untuk membuat yang baru
    //     // Anda dapat menggunakan metode atau logika lain sesuai kebutuhan Anda

    //     // Contoh sederhana (asumsi Anda memiliki model Layanan):
        
    //     // $lastLayanan = Layanan::where('kategori_layanan_id', $kategoriLayananId)->latest('layanan_id')->first();

    //     // if ($lastLayanan) {
    //     //     $lastNumber = intval(str_replace($kategoriLayananId . '-', '', $lastLayanan->layanan_id));
    //     //     $newNumber = $lastNumber + 1;
    //     // } else {
    //     //     $newNumber = 1;
    //     // }

    //     // return $kategoriLayananId . '-' . $newNumber;

    //     // Cari nomor tertinggi dari layanan dengan kategori_layanan_id yang sama
    //     $maxNumber = Layanan::where('kategori_layanan_id', $kategoriLayananId)
    //     ->max(DB::raw('CAST(SUBSTRING_INDEX(layanan_id, "-", -1) AS SIGNED)'));

    //     // Jika tidak ada layanan dengan kategori_layanan_id yang sama, nomor dimulai dari 1
    //     $newNumber = $maxNumber !== null ? $maxNumber + 1 : 1;

    //     return $kategoriLayananId . '-' . $newNumber;
    // }

    public function deleteLayanan($layanan_id)
    {
        $layanan = Layanan::findOrFail($layanan_id);
        $layanan->delete();

        return redirect()->route('ShowLayananData')->with('success', 'Berhasil menghapus Layanan!');;
    }

    public function displayJadwal(Request $request)
    {
        if ($request->ajax()) {
            $data = JadwalKlinik::select(['jadwal_klinik_id', 'tanggal', 'jam_mulai', 'jam_selesai', 'status', 'layanan_id', 'pekerja_id']);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nama_layanan', function ($jadwalKlinik) {
                        // Penggunaan relasi, untuk mendapatkan nama layanan
                        return $jadwalKlinik->Layanan->nama_layanan;
                    })
                    ->addColumn('namapekerja', function ($jadwalKlinik) {
                        // Penggunaan relasi, untuk mendapatkan nama pekerja
                        return $jadwalKlinik->Pekerja->namapekerja;
                    })
                   
                    ->addColumn('waktu', function ($jadwalKlinik) {
                        // Ambil hanya jam dan menit dari jam_mulai dan jam_selesai
                        $jamMulai = substr($jadwalKlinik->jam_mulai, 0, 5);
                        $jamSelesai = substr($jadwalKlinik->jam_selesai, 0, 5);
    
                        // Gabungkan hasilnya
                        $waktu = $jamMulai . ' - ' . $jamSelesai;

                        $waktu .= ' WIB';

                        return $waktu;
                    })
                    ->addColumn('action', function ($jadwalKlinik) {
                        // Memeriksa status jadwal dan menyesuaikan tampilan tombol
                        $editButton = '';
                        $deleteButton = '';
                        $detailButton = '';
                        
                        if ($jadwalKlinik->status == 'Aktif') {
                            $editButton = '<a href="'.route('UpdateJadwalForm', $jadwalKlinik->jadwal_klinik_id).'" class="btn btn-success btn-edit">Update</a>';
                        }

                        if ($jadwalKlinik->status == 'Dipesan') {
                            $detailButton = '<a href="'.route('DetailsJadwal', $jadwalKlinik->jadwal_klinik_id).'" class="btn btn-primary">Details</a>';
                        }
        
                        if ($jadwalKlinik->status == 'Nonaktif') {
                            $editButton = '<a href="'.route('UpdateJadwalForm', $jadwalKlinik->jadwal_klinik_id).'" class="btn btn-success btn-edit">Update</a>';
                            $deleteButton = '
                                <form method="POST" action="'.route('DeleteJadwalData', $jadwalKlinik->jadwal_klinik_id).'" style="display:inline">
                                    '.csrf_field().'
                                    '.method_field('DELETE').'
                                    <button type="submit" class="btn btn-danger btn-delete" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">Delete</button>
                                </form>';
                        }
        
                        return $detailButton . $editButton . $deleteButton;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $title = 'Data Jadwal Layanan';
        
        return view('jadwal.jadwal-klinik', compact('title'));
    }

    public function createJadwalForm()
    {
        $layanan = Layanan::whereIn('kategori_layanan_id', ['K-1', 'K-2'])
                    ->orderBy('kategori_layanan_id')
                    ->get();
                    
        $pekerja = Pekerja::where('peran', 'Dokter')
                    ->orWhere('peran', 'Groomer')
                    ->orderBy('peran')
                    ->get();
    
        return view('jadwal.create-jadwal', compact('pekerja', 'layanan'));
    }
    
    public function createJadwal(Request $request): RedirectResponse
    {
        try {
            \Log::info($request->all());

            $request->validate([
                'layanan_id' => ['required', 'string', 'max:10'],
                'pekerja_id' => ['required', 'string', 'max:10'],
                'tanggal' => ['required', 'date'],
                'jam_mulai' => ['required', 'date_format:H:i'],
                'jam_selesai' => ['required', 'date_format:H:i'],
                'status' => ['required', 'string'],
            ]);

            // Cari kategori_layanan_id berdasarkan nama_kategori
            // $kategori = KategoriLayanan::where('nama_kategori', $request->nama_kategori)->firstOrFail();

            $layanan = JadwalKlinik::create([
                'layanan_id' => $request->layanan_id,
                'pekerja_id' => $request->pekerja_id,
                'tanggal' => $request->tanggal,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'status' => $request->status,
            ]);

            $layanan->save();

            return redirect()->route('ShowJadwalKlinik')->with('success', 'Jadwal Berhasil Ditambahkan!');
        }
        catch (\Exception $e) {
            dd($e->getMessage());
            
        }

    }

    public function detailsJadwal($jadwal_klinik_id)
    {
        $jadwalKlinik = JadwalKlinik::findOrFail($jadwal_klinik_id);

        return view('jadwal.detail-jadwal', compact('jadwalKlinik'));
    }

    public function updateJadwalForm($jadwal_klinik_id)
    
    {
        $jadwal = JadwalKlinik::findOrFail($jadwal_klinik_id);
        $layanan = Layanan::whereIn('kategori_layanan_id', ['K-1', 'K-2'])
                    ->orderBy('kategori_layanan_id')
                    ->get();
                    
        $pekerja = Pekerja::where('peran', 'Dokter')
                    ->orWhere('peran', 'Groomer')
                    ->orderBy('peran')
                    ->get();
    
        return view('jadwal.update-jadwal', compact('jadwal', 'layanan', 'pekerja'));
    }

    public function updateJadwal(Request $request, $jadwal_klinik_id): RedirectResponse
    {
        try {
        $jadwal = JadwalKlinik::findOrFail($jadwal_klinik_id);

        $request->validate([
            'layanan_id' => ['required', 'string', 'max:10'],
            'pekerja_id' => ['required', 'string', 'max:10'],
            'tanggal' => ['required', 'date'],
            'jam_mulai' => ['required', 'string'],
            'jam_selesai' => ['required', 'string'],
            'status' => ['required', 'string'],
        ]);


        $jadwal->update([
            'layanan_id' => $request->layanan_id,
            'pekerja_id' => $request->pekerja_id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => $request->status,
        ]);

        return redirect()->route('ShowJadwalKlinik')->with('success', 'Berhasil Memperbarui Data Jadwal!');
    }

        catch (\Exception $e) {
            dd($e->getMessage());
            
        }
    }

    public function deleteJadwal($jadwal_klinik_id)
    {
        $jadwal = JadwalKlinik::findOrFail($jadwal_klinik_id);
        $jadwal->delete();

        return redirect()->route('ShowJadwalKlinik')->with('success', 'Berhasil Menghapus Jadwal!');;
    }
    
    public function tampilkanBuktiTransfer()
    {
        $title = 'Konfirmasi Pembayaran';

        $transaksi = Transaksi::where('status', 'Menunggu Pembayaran')
            ->whereNotNull('bukti_transfer')
            ->get();

        return view('admin.konfirmasi-pembayaran', compact('title', 'transaksi'));
    }

    public function downloadBukti($transaksi_id)
    {
        $transaksi = Transaksi::findOrFail($transaksi_id);
        
        $path = storage_path('app/public/' . $transaksi->bukti_transfer);

        return response()->download($path);
    }


    public function konfirmasiBuktiTransfer(Request $request, $transaction)
    {
        $transaksi = Transaksi::findOrFail($transaction);

        // Jika tombol Approve ditekan
        if ($request->has('approve')) {
            $transaksi->update([
                'status' => 'Pembayaran Berhasil',
            ]);

            
        }

        // Jika tombol Reject ditekan
        if ($request->has('reject')) {
            // Kosongkan bukti_transfer
            $transaksi->update([
                'bukti_transfer' => null,
            ]);

            
        }

        return redirect()->route('ShowBuktiPembayaran')->with('success', 'Berhasil mengkonfirmasi pembayaran!');
    }

    public function displayTransaksi(Request $request)
    {
        if ($request->ajax()) {
            $data = Transaksi::select(['transaksi_id', 'total_biaya', 'status', 'jadwal_klinik_id', 'user_id']);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nama_layanan', function ($transaksi) {
                        
                        return $transaksi->JadwalKlinik->Layanan->nama_layanan;
                    })
                    ->addColumn('namalengkap', function ($transaksi) {
                        // Penggunaan relasi, untuk mendapatkan nama pekerja
                        return $transaksi->User->namalengkap;
                    })
                   
                    ->addColumn('waktu', function ($transaksi) {
                        // Ambil tanggal, jam mulai, dan jam selesai
                        $tanggal = date('d M Y', strtotime($transaksi->JadwalKlinik->tanggal));
                        $jamMulai = substr($transaksi->JadwalKlinik->jam_mulai, 0, 5);
                        $jamSelesai = substr($transaksi->JadwalKlinik->jam_selesai, 0, 5);
                    
                        // Gabungkan hasilnya
                        $waktu = $tanggal . ' ( ' . $jamMulai . ' - ' . $jamSelesai . ' WIB ) ';
                    
                        return $waktu;
                    })

                    ->addColumn('total_biaya', function ($transaksi) {
                        // Menggunakan number_format untuk format uang dan menambahkan "Rp" di depannya
                        return 'Rp ' . number_format($transaksi->total_biaya, 0, ',', '.');
                    })

                    ->addColumn('action', function ($transaksi) {
                        // Memeriksa status jadwal dan menyesuaikan tampilan tombol
                        $detailButton = '';
                        
                        $detailButton = '<a href="'.route('DetailsTransaksi', $transaksi->transaksi_id).'" class="btn btn-primary">Details</a>';

                        return $detailButton;
                    })
                    
                    
                    ->make(true);
        }

        $title = 'Data Transaksi';
        
        return view('admin.data-transaksi', compact('title'));
    }

    public function detailsTransaksi($transaksi_id)
    {
        $transaksi = Transaksi::findOrFail($transaksi_id);

        $title = 'Detail Transaksi';

        return view('admin.detail-transaksi', compact('title', 'transaksi'));
    }
}

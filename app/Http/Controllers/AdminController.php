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
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Barryvdh\DomPDF\Facade\PDF;

class AdminController extends Controller
{
    //
    // public function displayUser()
    // {
    //     $data = User::all();
    //     return view('admin.data-user',compact(['data']));
    // }

    public function adminDashboard()
    {
        $this->CekJadwalKlinik();

        $transactionSelesai = Transaksi::whereMonth('tanggal', now()->month)
        ->where('status', 'Selesai')
        ->get();

        $transactions = Transaksi::whereMonth('tanggal', now()->month)->get();
    
        $totalIncome = $transactionSelesai->sum('total_biaya');
        $waitingPaymentCount = $transactions->where('status', 'Menunggu Pembayaran')->count();
        $successPaymentCount = $transactions->where('status', 'Pembayaran Berhasil')->count();
        $completedCount = $transactions->where('status', 'Selesai')->count();

        $monthNames = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
    
        $currentMonthYear = $monthNames[now()->month] . ' ' . now()->year;

        $title = 'Dashboard';

        return view('admin.admin-dashboard', compact('title', 'totalIncome', 'waitingPaymentCount', 'successPaymentCount', 'completedCount', 'currentMonthYear'));
    }

    public function dokterDashboard()
    {
        $this->CekJadwalKlinik();

        $title = 'Dashboard';

        return view('admin.admin-dashboard', compact('title', 'totalIncome', 'waitingPaymentCount', 'successPaymentCount', 'completedCount', 'currentMonthYear'));
    }

    public function displayUser(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select(['user_id', 'namalengkap', 'jeniskelamin', 'tanggallahir', 'alamat', 'email', 'nomortelepon']);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($user){
                        
                        // $deleteUrl = route('DeleteUserData', $user->user_id);
                        $editUrl = route('UpdateUserForm', ['user_id' => $user->user_id]);
     
                        $actionBtn = '
                            <a href="' . $editUrl . '" class="edit btn btn-success btn-sm mb-2"><i class="fas fa-edit"></i> Update</a>';

                        // $actionBtn .= '
                        //     <form action="' . $deleteUrl . '" method="POST" class="d-inline">
                        //         ' . csrf_field() . '
                        //         ' . method_field('DELETE') . '
                        //         <button type="submit" class="delete btn btn-danger btn-sm"><i class="fas fa-trash"></i>  Delete</button>
                        //     </form>';
    
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $title = 'Data User';
        
        return view('admin.data-user', compact('title'));
    }

    public function CreateUserForm()
    {
        $title = 'Create Data User';

        return view('admin.create-user', compact('title'));
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

        $title = 'Update Data User';

        return view('admin.update-user', compact('user', 'title'));
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
                    // ->addColumn('action', function ($pet) {
                    //     return '<button class="btn btn-primary">Detail</button>';
                    // })
                    ->rawColumns(['image'])
                    ->make(true);
        }

        $title = 'Data Pasien';
        
        return view('admin.data-pasien', compact ('title'));
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
                        
                        // $deleteUrl = route('DeletePekerjaData', $pekerja->pekerja_id);
                        $editUrl = route('UpdatePekerjaForm', ['pekerja_id' => $pekerja->pekerja_id]);

                        $actionBtn = '
                            <a href="' . $editUrl . '" class="edit btn btn-success btn-sm mb-2"><i class="fas fa-edit"></i> Update</a>';

                        // $actionBtn .= '
                        //     <form action="' . $deleteUrl . '" method="POST" class="d-inline">
                        //         ' . csrf_field() . '
                        //         ' . method_field('DELETE') . '
                        //         <button type="submit" class="delete btn btn-danger btn-sm"><i class="fas fa-trash"></i>  Delete</button>
                        //     </form>';
    
                        return $actionBtn;
                    })
                    ->rawColumns(['foto','action'])
                    ->make(true);
        }

        $title = 'Data Pekerja';
        
        return view('admin.data-pekerja', compact('title'));
    }

    public function CreatePekerjaForm()
    {
        $title = 'Tambah Data Pekerja';

        return view('admin.create-pekerja', compact('title'));
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
        $title = 'Update Data Pekerja';

        return view('admin.update-pekerja', compact('pekerja', 'title'));
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
            $data = Layanan::select(['layanan_id', 'kategori_layanan', 'nama_layanan', 'biaya_booking', 'harga_layanan', 'deskripsi_layanan']);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($layanan){
                        
                        // $deleteUrl = route('DeleteLayananData', $layanan->layanan_id);
                        $editUrl = route('UpdateLayananForm', ['layanan_id' => $layanan->layanan_id]);
     
                        $actionBtn = '
                            <a href="' . $editUrl . '" class="edit btn btn-success btn-sm mb-2"><i class="fas fa-edit"></i> Update</a>';

                        // $actionBtn .= '
                        //     <form action="' . $deleteUrl . '" method="POST" class="d-inline">
                        //         ' . csrf_field() . '
                        //         ' . method_field('DELETE') . '
                        //         <button type="submit" class="delete btn btn-danger btn-sm"><i class="fas fa-trash"></i>  Delete</button>
                        //     </form>';
    
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $title = 'Data Layanan';
        
        return view('admin.data-layanan', compact('title'));
    }

    public function CreateLayananForm()
    {
        $title = 'Tambah Layanan';

        return view('admin.create-layanan', compact('title'));
    }
    
    public function CreateLayanan(Request $request): RedirectResponse
    {
        try {
            \Log::info($request->all());

            $request->validate([
                'kategori_layanan' => ['required', 'string'],
                'nama_layanan' => ['required', 'string'],
                'biaya_booking' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
                'harga_layanan' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
                'deskripsi_layanan' => ['required', 'string'],
                'jenis_layanan_hewan' => ['nullable', 'string'],
                'stok_kandang' => ['nullable', 'integer'],
            ]);

            // Cek apakah jenis_hewan harus diisi berdasarkan kategori_layanan
            if (in_array($request->kategori_layanan, ['Pet Grooming', 'Pet Hotel'])) {
                $request->validate([
                    'jenis_layanan_hewan' => ['required'],
                ]);
            }

            // Cari kategori_layanan_id berdasarkan nama_kategori
            // $kategori = KategoriLayanan::where('nama_kategori', $request->nama_kategori)->firstOrFail();

            $layanan = Layanan::create([
                'kategori_layanan' => $request->kategori_layanan,
                'nama_layanan' => $request->nama_layanan,
                'biaya_booking' => $request->biaya_booking,
                'harga_layanan' => $request->harga_layanan,
                'deskripsi_layanan' => $request->deskripsi_layanan,
                'jenis_layanan_hewan' => $request->jenis_layanan_hewan,
                'stok_kandang' => $request->stok_kandang,
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

        $title = 'Update Data Layanan';
    
        return view('admin.update-layanan', compact('layanan', 'title'));
    }


    public function updateLayanan(Request $request, $layanan_id): RedirectResponse
    {
        try {
            $layanan = Layanan::findOrFail($layanan_id);

            \Log::info($request->all());

            $request->validate([
                'kategori_layanan' => ['required', 'string'],
                'nama_layanan' => ['required', 'string'],
                'biaya_booking' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
                'harga_layanan' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
                'deskripsi_layanan' => ['required', 'string'],
                'jenis_layanan_hewan' => ['nullable', 'string'],
                'stok_kandang' => ['nullable', 'integer'],
            ]);

            // Cek apakah jenis_hewan harus diisi berdasarkan kategori_layanan baru
            if (in_array($request->kategori_layanan, ['Pet Grooming', 'Pet Hotel'])) {
                $request->validate([
                    'jenis_layanan_hewan' => ['required', 'string'],
                ]);

                if (in_array($request->kategori_layanan, ['Pet Hotel'])) {
                    $request->validate([
                        'stok_kandang' => ['required', 'integer'],
                    ]);
                }
            } else {
                // Jika kategori_layanan bukan Pet Grooming atau Pet Hotel, jenis_hewan diabaikan
                $request->merge(['jenis_layanan_hewan' => null]);
            }

            $layanan->update([
                'kategori_layanan' => $request->kategori_layanan,
                'nama_layanan' => $request->nama_layanan,
                'biaya_booking' => $request->biaya_booking,
                'harga_layanan' => $request->harga_layanan,
                'deskripsi_layanan' => $request->deskripsi_layanan,
                'jenis_layanan_hewan' => $request->jenis_layanan_hewan,
                'stok_kandang' => $request->stok_kandang,
            ]);

            return redirect()->route('ShowLayananData')->with('success', 'Berhasil Memperbarui Data Layanan!');

        }
        catch (\Exception $e) {
            dd($e->getMessage());
            
        }
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
                        // $deleteButton = '';
                        $detailButton = '';
                        
                        if ($jadwalKlinik->status == 'Aktif') {
                            $editButton = '<a href="'.route('UpdateJadwalForm', $jadwalKlinik->jadwal_klinik_id).'" class="btn btn-success btn-edit">Update</a>';
                        }

                        if ($jadwalKlinik->status == 'Dipesan' || $jadwalKlinik->status == 'Selesai') {
                            $detailButton = '<a href="'.route('DetailsJadwal', $jadwalKlinik->jadwal_klinik_id).'" class="btn btn-primary">Details</a>';
                        }
        
                        if ($jadwalKlinik->status == 'Nonaktif') {
                            $editButton = '<a href="'.route('UpdateJadwalForm', $jadwalKlinik->jadwal_klinik_id).'" class="btn btn-success btn-edit">Update</a>';
                            // $deleteButton = '
                            //     <form method="POST" action="'.route('DeleteJadwalData', $jadwalKlinik->jadwal_klinik_id).'" style="display:inline">
                            //         '.csrf_field().'
                            //         '.method_field('DELETE').'
                            //         <button type="submit" class="btn btn-danger btn-delete" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">Delete</button>
                            //     </form>';
                        }
        
                        return $detailButton . $editButton;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $this->CekJadwalKlinik();

        $title = 'Data Jadwal Layanan';
        
        return view('jadwal.jadwal-klinik', compact('title'));
    }

    public function CekJadwalKlinik()
    {
        $CekKlinik = JadwalKlinik::where('status', 'Aktif')->get();
        $now = Carbon::now()->tz('Asia/Jakarta');

        foreach ($CekKlinik as $jadwal) {
            
            if ($now->toDateString() > $jadwal->tanggal) {
                
                $jadwal->update(['status' => 'Nonaktif']);
            }
        }
    }

    public function createJadwalForm()
    {
        $layanan = Layanan::where('kategori_layanan', 'Pet Clinic')
                    ->orderBy('kategori_layanan')
                    ->get();
                    
        $pekerja = Pekerja::where('peran', 'Dokter')
                    ->orderBy('peran')
                    ->get();

        $title = 'Tambah Jadwal Layanan';
    
        return view('jadwal.create-jadwal', compact('pekerja', 'layanan', 'title'));
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

        $title = 'Detail Jadwal Layanan';

        return view('jadwal.detail-jadwal', compact('jadwalKlinik', 'title'));
    }

    public function updateJadwalForm($jadwal_klinik_id)
    {
        $jadwal = JadwalKlinik::findOrFail($jadwal_klinik_id);

        $layanan = Layanan::where('kategori_layanan', 'Pet Clinic')
                    ->orderBy('kategori_layanan')
                    ->get();
                    
        $pekerja = Pekerja::where('peran', 'Dokter')
                    ->orderBy('peran')
                    ->get();

        $title = 'Update Jadwal Layanan';
    
        return view('jadwal.update-jadwal', compact('jadwal', 'layanan', 'pekerja', 'title'));
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

        $transaksi = Transaksi::whereIn('status', ['Menunggu Pembayaran', 'Pembayaran Gagal'])
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
                'alasan_reject' => null,
            ]);

            
        }

        // Jika tombol Reject ditekan
        if ($request->has('reject')) {
            
            // Kosongkan bukti_transfer
            $transaksi->update([
                'bukti_transfer' => null,
                'status' => 'Pembayaran Gagal',
                'alasan_reject' => $request->input('rejectReason'),
            ]);

            
        }

        return redirect()->route('ShowBuktiPembayaran')->with('success', 'Berhasil mengkonfirmasi pembayaran!');
    }

    public function displayTransaksi(Request $request)
    {
        if ($request->ajax()) {
            $data = Transaksi::select(['transaksi_id', 'tanggal', 'waktu', 'layanan_id', 'total_biaya', 'status', 'jadwal_klinik_id', 'user_id']);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nama_layanan', function ($transaksi) {
                        
                        return $transaksi->Layanan->nama_layanan;
                    })
                    ->addColumn('namalengkap', function ($transaksi) {
                        // Penggunaan relasi, untuk mendapatkan nama pekerja
                        return $transaksi->User->namalengkap;
                    })
                    
                    ->addColumn('waktu', function ($transaksi) {

                        // Ambil tanggal, jam mulai, dan jam selesai
                        $tanggal = date('d M Y', strtotime($transaksi->tanggal));
                        $jamMulai = substr($transaksi->waktu, 0, 5);

                        if ($transaksi->layanan->kategori_layanan == 'Pet Clinic') {

                            $jamSelesai = substr($transaksi->JadwalKlinik->jam_selesai, 0, 5);

                            $waktu = $tanggal . ' ( ' . $jamMulai . ' - ' . $jamSelesai . ' WIB ) ';
                        }

                        else {
                            // Gabungkan hasilnya
                            $waktu = $tanggal . ' ( ' . $jamMulai . ' WIB ) ';
                        }
                    
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
        $transaksi = Transaksi::with('rekamMedis')->findOrFail($transaksi_id);

        $estimasiCheckout = Carbon::parse($transaksi->tanggal)->addDays($transaksi->lama_tinggal);

        $waktuSelesaiGrooming = session('waktu_selesai_grooming');

        $title = 'Detail Transaksi';

        return view('admin.detail-transaksi', compact('title', 'transaksi', 'estimasiCheckout', 'waktuSelesaiGrooming'));
    }

    public function selesaikanTransaksi($transaksi_id)
    {
        $transaksi = Transaksi::findOrFail($transaksi_id);

        // Toggle status dan waktu nonaktif berdasarkan status sebelumnya
        if ($transaksi->status === 'Pembayaran Berhasil' || $transaksi->status === 'Proses Grooming Selesai') {
            
            $transaksi->status = 'Selesai';

            if ($transaksi->Layanan->kategori_layanan === 'Pet Clinic') {
                $transaksi->JadwalKlinik->update(['status' => 'Selesai']);
            }

            else if ($transaksi->Layanan->kategori_layanan === 'Pet Hotel') {
                $layanan = $transaksi->Layanan;
                $layanan->stok_kandang++;
                $layanan->save();
            }
        } 

        $transaksi->save();

        return redirect()->route('ShowTransaksi')->with('success', 'Status transaksi telah diperbarui.');
    }

    public function nonaktifkanTransaksi($transaksi_id)
    {
        $transaksi = Transaksi::findOrFail($transaksi_id);

        // Toggle status dan waktu nonaktif berdasarkan status sebelumnya
        if ($transaksi->status === 'Menunggu Pembayaran' || $transaksi->status === 'Pembayaran Gagal') {
            
            $transaksi->update(['status' => 'Expired']);
            
            if ($transaksi->Layanan->kategori_layanan === 'Pet Clinic') {
                $transaksi->JadwalKlinik->update(['status' => 'Aktif']);
            }

            else if ($transaksi->Layanan->kategori_layanan === 'Pet Hotel') {
                $layanan = $transaksi->Layanan;
                $layanan->stok_kandang++;
                $layanan->save();
            }
            
        } 

        return redirect()->route('ShowTransaksi')->with('success', 'Status transaksi telah diperbarui.');
    }

    public function displayLaporanTransaksi()
    {
        $title = 'Cetak Laporan Transaksi';

        return view('admin.laporan-transaksi', compact('title'));
    }

    public function cetak_laporan(Request $request) {
        // Mendapatkan input dari formulir
        $layananId = $request->input('layanan_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Membuat query dasar untuk transaksi
        $query = Transaksi::query()->where('status', 'Selesai');
    
        // Filter berdasarkan layanan_id jika dipilih
        if ($layananId && $layananId !== 'all') {
            $query->whereHas('layanan', function ($query) use ($layananId) {
                $query->where('kategori_layanan', $layananId);
            });
        }
    
        // Filter berdasarkan tanggal mulai jika dipilih
        if ($startDate) {
            $query->where('tanggal', '>=', $startDate);
        }
    
        // Filter berdasarkan tanggal akhir jika dipilih
        if ($endDate) {
            $query->where('tanggal', '<=', $endDate);
        }
    
        // Mengambil data transaksi yang telah difilter
        $transaksi = $query->get();
    
        // Membuat PDF
        $data = [
            'jenis_laporan' => $layananId !== 'all' ? "Transaksi $layananId" : 'Semua Transaksi',
            'periode' => $this->formatPeriode($startDate, $endDate),
        ];

        $pdf = PDF::loadView('laporan.cetak-laporan', compact('transaksi', 'data'))->setPaper('a4','landscape');
    
        // Mengirimkan PDF untuk di-download
        return $pdf->download('laporan_transaksi.pdf');
    }

    private function formatPeriode($startDate, $endDate) {
        $formattedStartDate = $startDate ? date('d/m/Y', strtotime($startDate)) : '';
        $formattedEndDate = $endDate ? date('d/m/Y', strtotime($endDate)) : '';
    
        return $formattedStartDate && $formattedEndDate ? "Periode: $formattedStartDate hingga $formattedEndDate" : 'Tidak Ada Periode';
    }
    
    public function view_laporan(Request $request) {

       // Mendapatkan input dari formulir
       $layananId = $request->input('layanan_id');
       $startDate = $request->input('start_date');
       $endDate = $request->input('end_date');
   
       // Membuat query dasar untuk transaksi
       $query = Transaksi::query()->where('status', 'Selesai');
   
       // Filter berdasarkan layanan_id jika dipilih
       if ($layananId && $layananId !== 'all') {
           $query->whereHas('layanan', function ($query) use ($layananId) {
               $query->where('kategori_layanan', $layananId);
           });
       }
   
       // Filter berdasarkan tanggal mulai jika dipilih
       if ($startDate) {
           $query->where('tanggal', '>=', $startDate);
       }
   
       // Filter berdasarkan tanggal akhir jika dipilih
       if ($endDate) {
           $query->where('tanggal', '<=', $endDate);
       }
   
       // Mengambil data transaksi yang telah difilter
       $transaksi = $query->get();

       $totalIncome = $transaksi->sum('total_biaya');
   
       // Membuat PDF
       $data = [
           'jenis_laporan' => $layananId !== 'all' ? "Transaksi $layananId" : 'Semua Transaksi',
           'periode' => $this->formatPeriode($startDate, $endDate),
           'totalIncome' => $totalIncome,
       ];

       $pdf = PDF::loadView('laporan.cetak-laporan', compact('transaksi', 'data'))->setPaper('a4','landscape');
       
       return $pdf->stream('laporan_transaksi.pdf');
    }
}

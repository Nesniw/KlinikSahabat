<?php

namespace App\Http\Controllers;

use App\Events\TransaksiUpdated;
use App\Models\JadwalKlinik;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\KategoriLayanan;
use App\Models\Layanan;
use App\Models\Pets;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Pusher\Pusher;

class ReservasiController extends Controller
{

    public function getLayananPetGrooming()
    {
        // Ambil semua layanan dengan kategori_layanan = 'Pet Hotel'
        $layanans = Layanan::where('kategori_layanan', 'Pet Grooming')->get();         

        return view('reservasi.reservasi-pet-grooming', ['title' => 'Reservasi Pet Grooming'], compact('layanans'));
    }

    public function getHewanGroomingByLayanan(Request $request)
    {

        $request->validate([
            'layanan_id' => ['required', 'string'],
            'catatan' => ['nullable', 'string'],
        ]);

        $selectedLayanan = $request->layanan_id;
        $selectedCatatan = $request->catatan;

        // Simpan layanan_id ke dalam session
        session([
            'selected_layanan' => $selectedLayanan,
            'selected_catatan' => $selectedCatatan
        ]);

        // Ambil data jenis_layanan_hewan berdasarkan layanan_id
        $selectedJenis = Layanan::where('layanan_id', $selectedLayanan)->value('jenis_layanan_hewan');

        $userPets = Auth::user()->pets;

        if ($selectedJenis == 'Anjing Kecil') {
            $userPets = $userPets->where('jenishewan', 'Anjing')->whereBetween('berat', [1, 5]);
        }
        
        else if ($selectedJenis == 'Anjing Sedang'){
            $userPets = $userPets->where('jenishewan', 'Anjing')->whereBetween('berat', [6, 10]);
        }

        else if ($selectedJenis == 'Anjing Besar'){
            $userPets = $userPets->where('jenishewan', 'Anjing')->whereBetween('berat', [11, 20]);
        }
        
        else if ($selectedJenis == 'Kucing'){
            $userPets = $userPets->where('jenishewan', 'Kucing');
        }

        // Cek apakah user memiliki hewan sesuai jenis yang dipilih
        $hasPets = $userPets->isNotEmpty();

        return view('reservasi.grooming-pilih-hewan', ['title' => 'Reservasi Pet Grooming'], compact('userPets', 'hasPets'));
    }

    public function chooseJadwalPetGrooming(Request $request)
    {
        $request->validate([
            'kode_pasien' => ['required', 'string'],
        ]);

        // Simpan layanan dan hewan yang dipilih ke dalam session atau variabel sementara
        session(['selected_pet' => $request->kode_pasien,]);

        return view('reservasi.grooming-pilih-tanggal', ['title' => 'Reservasi Pet Grooming']);
    }

    public function prosesJadwalPetGrooming(Request $request)
    {
        try {
            $request->validate([
                'tanggal' => ['required', 'date'],
                'waktu' => ['required', 'date_format:H:i'],
            ]);

            // Ambil data sebelumnya dari session
            $selectedLayanan = session('selected_layanan');
            $selectedPet = session('selected_pet');
            $selectedCatatan = session('selected_catatan');

            $user = Auth::user();
            $userId = $user->user_id;

            // Simpan data transaksi ke database
            $transaksi = Transaksi::create([
                'layanan_id' => $selectedLayanan,
                'user_id' => $userId,
                'kode_pasien' => $selectedPet,
                'tanggal' => $request->tanggal,
                'waktu' => $request->waktu,
                'catatan' => $selectedCatatan,
                'status' => 'Menunggu Pembayaran',
            ]);
          
            $expirationTime = now()->addMinutes(10);
            session(['transaksi_expiration_' . $transaksi->transaksi_id => $expirationTime->timestamp]);

            $transaksi->update([
                'waktu_ekspirasi' => $expirationTime,
            ]);

            // Hitung total biaya
            $harga = $transaksi->layanan->harga_layanan;
            $totalBiaya = $transaksi->layanan->biaya_booking + $harga;
            
            $transaksi->update([
                'harga' => $harga,
                'total_biaya' => $totalBiaya,
            ]);

            return redirect()->route('ShowHalamanPembayaran', [
                'transaksi_id' => $transaksi->transaksi_id,
                
            ]);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }


    public function getLayananPetHotel()
    {
        // Ambil semua layanan dengan kategori_layanan = 'Pet Hotel'
        $layanans = Layanan::where('kategori_layanan', 'Pet Hotel')->get();         

        return view('reservasi.reservasi-pet-hotel', ['title' => 'Reservasi Pet Hotel'], compact('layanans'));
    }

    public function getHewanByLayanan(Request $request)
    {

        $request->validate([
            'layanan_id' => ['required', 'string'],
        ]);

        $selectedLayanan = $request->layanan_id;

        $layanan = Layanan::find($selectedLayanan);

        if ($layanan->stok_kandang === 0){

            return redirect()->back()->with('error', 'Maaf, kandang untuk layanan tersebut sudah habis.');
        }

        else {

            // Simpan layanan_id ke dalam session
            session(['selected_layanan' => $selectedLayanan]);

            // Ambil data jenis_layanan_hewan berdasarkan layanan_id
            $selectedJenis = Layanan::where('layanan_id', $selectedLayanan)->value('jenis_layanan_hewan');

            $userPets = Auth::user()->pets;

            if ($selectedJenis == 'Anjing Kecil') {
                $userPets = $userPets->where('jenishewan', 'Anjing')->whereBetween('berat', [1, 5]);
            }
            
            else if ($selectedJenis == 'Anjing Sedang'){
                $userPets = $userPets->where('jenishewan', 'Anjing')->whereBetween('berat', [6, 10]);
            }
            
            else if ($selectedJenis == 'Kucing'){
                $userPets = $userPets->where('jenishewan', 'Kucing');
            }

            // Cek apakah user memiliki hewan sesuai jenis yang dipilih
            $hasPets = $userPets->isNotEmpty();
        }

        return view('reservasi.hotel-pilih-hewan', ['title' => 'Reservasi Pet Hotel'], compact('userPets', 'hasPets'));
    }

    public function chooseJadwalPetHotel(Request $request)
    {
        $request->validate([
            'kode_pasien' => ['required', 'string'],
        ]);

        // Simpan layanan dan hewan yang dipilih ke dalam session atau variabel sementara
        session(['selected_pet' => $request->kode_pasien,]);

        return view('reservasi.hotel-pilih-tanggal', ['title' => 'Reservasi Pet Hotel']);
    }

    public function prosesJadwalPetHotel(Request $request)
    {
        try {
            $request->validate([
                'tanggal' => ['required', 'date'],
                'lama_tinggal' => ['required', 'string'],
                'waktu' => ['required', 'date_format:H:i'],
                'catatan' => ['nullable', 'string'],
            ]);

            // Ambil data sebelumnya dari session
            $selectedLayanan = session('selected_layanan');
            $selectedPet = session('selected_pet');

            $user = Auth::user();
            $userId = $user->user_id;

            // Simpan data transaksi ke database
            $transaksi = Transaksi::create([
                'layanan_id' => $selectedLayanan,
                'user_id' => $userId,
                'kode_pasien' => $selectedPet,
                'tanggal' => $request->tanggal,
                'waktu' => $request->waktu,
                'lama_tinggal' => $request->lama_tinggal,
                'catatan' => $request->catatan,
                'status' => 'Menunggu Pembayaran',
            ]);

            // Kurangin stok kandang buat setiap kali transaksi
            $layanan = Layanan::findOrFail($selectedLayanan);
            $layanan->stok_kandang--;
            $layanan->save();

          
            $expirationTime = now()->addMinutes(1);
            session(['transaksi_expiration_' . $transaksi->transaksi_id => $expirationTime->timestamp]);

            $transaksi->update([
                'waktu_ekspirasi' => $expirationTime,
            ]);

            // Hitung total biaya
            $harga = $transaksi->layanan->harga_layanan;
            $lamatinggal = $transaksi->lama_tinggal;
            $totalBiaya = $transaksi->layanan->biaya_booking + ($harga * $lamatinggal);
            
            $transaksi->update([
                'harga' => $harga,
                'total_biaya' => $totalBiaya,
            ]);

            return redirect()->route('ShowHalamanPembayaran', [
                'transaksi_id' => $transaksi->transaksi_id,
                
            ]);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }


    public function getLayananPetClinic()
    {
        try {
            $layanans = Layanan::where('kategori_layanan', 'Pet Clinic')->get();         

            $userPets = Auth::user()->pets;
            
            return view('reservasi.formServiceAndPet',['title' => 'Reservasi Clinic'], compact('layanans', 'userPets'));
        }
        catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    // public function chooseServiceCategory(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'kategori_layanan' => ['required', 'string'],
    //         ]);
    
    //         // Simpan kategori layanan yang dipilih ke dalam session atau variabel sementara
    //         session(['selected_category' => $request->kategori_layanan_id]);
    
    //         // Ambil layanan berdasarkan kategori yang dipilih
    //         $selectedCategory = $request->kategori_layanan_id;
    //         $layanans = Layanan::where('kategori_layanan_id', $selectedCategory)->get();

    //         $userPets = Auth::user()->pets;
            
    //         return view('reservasi.formServiceAndPet',['title' => 'Reservasi Clinic'], compact('layanans', 'userPets'));
    //     }
    //     catch (\Exception $e) {
    //         dd($e->getMessage());
    //     }
    // }

    public function chooseServiceAndPet(Request $request)
    {
        $request->validate([
            'layanan_id' => ['required', 'string'],
            'kode_pasien' => ['required', 'string'],
        ]);

        // Simpan layanan dan hewan yang dipilih ke dalam session atau variabel sementara
        session([
            'selected_service' => $request->layanan_id,
            'selected_pet' => $request->kode_pasien,
        ]);

        // Astagaa udah berjam-jam ngebug ternyata itu gara-gara timezone nya bukan timezone Indonesia
        $now = Carbon::now()->tz('Asia/Jakarta');

        // Validasi tampilin data, dan urutin data yang ditampilin dari tanggal abis tuh jam_mulai
        $jadwals = JadwalKlinik::where('layanan_id', $request->layanan_id)
                ->where('status', 'Aktif')
                ->where(function ($query) use ($now) {
                    $oneHourAfterNow = $now->copy()->addHour();
            
                    $query->where('tanggal', '>', $now->toDateString())
                        ->orWhere(function ($subquery) use ($now, $oneHourAfterNow) {
                            $subquery->where('tanggal', $now->toDateString())
                                ->where('jam_mulai', '>', $oneHourAfterNow->format('H:i:s'));
                        });
                })
                ->orderBy('tanggal')
                ->orderBy('jam_mulai')
                ->get();

        $jadwals->each(function ($jadwal) {
            $jadwal->tanggal = Carbon::parse($jadwal->tanggal)->isoFormat('DD-MM-YYYY');  
        });

        // Jadwal yang mau ditampilin dikategoriin per pekerja dan per tanggal
        $groupedJadwals = $jadwals->groupBy([
            'pekerja.namapekerja',
            function ($jadwal) {
                return Carbon::parse($jadwal->tanggal)->locale('id')->isoFormat('dddd, DD-MM-YYYY');  
            },
        ]);

        // Check if there are no active schedules
        if ($jadwals->isEmpty()) {
            return view('reservasi.formChooseSchedule', ['title' => 'Reservasi Clinic', 'noSchedules' => true]);
        }

        return view('reservasi.formChooseSchedule', ['title' => 'Reservasi Clinic'] , compact('groupedJadwals'));
    }

    public function chooseSchedule(Request $request)
    {
        try {
            
            $request->validate([
                'jadwal_klinik_id' => ['required', 'string'],
            ]);

            // Ambil data sebelumnya dari session
            $selectedService = session('selected_service');
            $selectedPet = session('selected_pet');
            $selectedSchedule = $request->jadwal_klinik_id;

            $user = Auth::user();
            $userId = $user->user_id;

            // Ambil data dari jadwal klinik
            $jadwal = JadwalKlinik::findOrFail($selectedSchedule);

            if ($jadwal->status === 'Dipesan' || $jadwal->status === 'Nonaktif') {

                return redirect()->route('ReservasiClinic')->with('error', 'Jadwal sudah tidak tersedia.');
            }
            
            // Simpan data transaksi ke database
            $transaksi = Transaksi::create([
                'jadwal_klinik_id' => $selectedSchedule,
                'layanan_id' => $selectedService,
                'user_id' => $userId,
                'kode_pasien' => $selectedPet,
                'status' => 'Menunggu Pembayaran',
                'tanggal' => $jadwal->tanggal,
                'waktu' => $jadwal->jam_mulai,
            ]);

            $expirationTime = now()->addMinutes(1);
            session(['transaksi_expiration_' . $transaksi->transaksi_id => $expirationTime->timestamp]);

            $transaksi->update([
                'waktu_ekspirasi' => $expirationTime,
            ]);

            // Update the status in the jadwal_klinik table to "Dipesan"
            $jadwal->status = 'Dipesan';
            $jadwal->save();

            // Hitung total biaya
            $harga = $transaksi->layanan->harga_layanan;
            $totalBiaya = $transaksi->layanan->biaya_booking + $harga;

            // Update the total biaya in the transaksi table
            $transaksi->update([
                'harga' => $harga,
                'total_biaya' => $totalBiaya,
            ]);
            


            // Pass the transaction details and total biaya to the view
            // return view('reservasi.halaman-transaksi', [
            //     'title' => 'Halaman Transaksi',
            //     'transaksi' => $transaksi,
            // ]); 

            return redirect()->route('ShowHalamanPembayaran', [
                'transaksi_id' => $transaksi->transaksi_id,
            ]);
            
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    // private function broadcastTransactionUpdate($transaksi)
    // {
    //     $pusher = new Pusher(
    //         env('PUSHER_APP_KEY'),
    //         env('PUSHER_APP_SECRET'),
    //         env('PUSHER_APP_ID'),
    //         [
    //             'cluster' => env('PUSHER_APP_CLUSTER'),
    //             'useTLS' => true,
    //         ]
    //     );

    //     // Trigger event ke channel "transactions" dengan nama event "transaction-updated"
    //     $pusher->trigger('transactions', 'transaction-updated', [
    //         'transaction_id' => $transaksi->transaksi_id,
    //         'status' => $transaksi->status,
    //     ]);
    // }

    public function showHalamanPembayaran($transaksi_id)
    {
        $transaksi = Transaksi::findOrFail($transaksi_id);

        // Check if the authenticated user owns the transaction
        $user = Auth::user();
        if ($user->user_id !== $transaksi->user_id) {
            abort(403, 'Unauthorized action.');
        }

        if ($transaksi->status === 'Menunggu Pembayaran' || $transaksi->status === 'Pembayaran Gagal') {
            // Cek apakah waktu expiration telah habis
            $expirationTimestamp = session('transaksi_expiration_' . $transaksi->transaksi_id);
            $expirationTime = Carbon::parse($expirationTimestamp);
            $now = now();

            if ($now >= $expirationTime) {
                // Hapus session
                session()->forget('transaksi_expiration_' . $transaksi->transaksi_id);

                // Perbarui status transaksi menjadi "Expired"
                $transaksi->update(['status' => 'Expired']);

                if ($transaksi->Layanan->kategori_layanan === 'Pet Clinic') {
                    // Perbarui status jadwal_transaksi menjadi "Aktif"
                    $jadwal_klinik = $transaksi->JadwalKlinik;
                    $jadwal_klinik->update(['status' => 'Aktif']);
                 }

                else if ($transaksi->Layanan->kategori_layanan === 'Pet Hotel') {
                    $layanan = $transaksi->Layanan;
                    $layanan->stok_kandang++;
                    $layanan->save();
                }
            }
        }

        if ($transaksi->status === 'Expired') {
            // Set bukti_transfer ke null jika transaksi expired
            $transaksi->update(['bukti_transfer' => null]);
        }
        
        return view('reservasi.halaman-transaksi', ['title' => 'Halaman Transaksi'], compact('transaksi'));
    }

    public function kirimBuktiPembayaran(Request $request, $transaksi_id)
    {
        try {
            $transaksi = Transaksi::findOrFail($transaksi_id);

            // Jika status transaksi sudah "Expired", tidak perlu melanjutkan pembaruan
            if ($transaksi->status === 'Expired') {
                return redirect()->back()->with('error', 'Waktu untuk mengunggah bukti pembayaran telah habis.');
            }

            // Cek apakah waktu expiration telah habis
            $expirationTimestamp = session('transaksi_expiration_' . $transaksi->transaksi_id);
            $expirationTime = Carbon::parse($expirationTimestamp);
            $now = now();

            if ($now >= $expirationTime) {
                // Hapus session
                session()->forget('transaksi_expiration_' . $transaksi->transaksi_id);

                // Perbarui status transaksi menjadi "Expired"
                $transaksi->update(['status' => 'Expired']);

                if ($transaksi->Layanan->kategori_layanan === 'Pet Clinic') {
                    // Perbarui status jadwal_transaksi menjadi "Aktif"
                    $jadwal_klinik = $transaksi->JadwalKlinik;
                    $jadwal_klinik->update(['status' => 'Aktif']);
                 }

                else if ($transaksi->Layanan->kategori_layanan === 'Pet Hotel') {
                    $layanan = $transaksi->Layanan;
                    $layanan->stok_kandang++;
                    $layanan->save();
                }

                return redirect()->back()->with('error', 'Waktu untuk mengunggah bukti pembayaran telah habis.');
            }

            $request->validate([
                'bukti_transfer' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $buktiPath = $transaksi->bukti_transfer;

            if ($request->hasFile('bukti_transfer')) {
                // Jika ada gambar baru diupload, hapus gambar lama
                Storage::delete('public/' . $transaksi->bukti_transfer);

                // Simpan gambar baru dan update path
                $buktiPath = $request->file('bukti_transfer')->store('bukti_pembayaran', 'public');
            } else {
                $buktiPath = null;
            }

            $transaksi->update([
                'bukti_transfer' => $buktiPath,
            ]);

            return redirect()->route('ShowHalamanPembayaran', ['transaksi_id' => $transaksi->transaksi_id,])
                ->with('success', 'Bukti transfer berhasil diupload! Mohon tunggu konfirmasi dari Admin');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}

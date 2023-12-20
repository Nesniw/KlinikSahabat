<?php

namespace App\Http\Controllers;

use App\Models\JadwalKlinik;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\KategoriLayanan;
use App\Models\Layanan;
use App\Models\Pets;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservasiController extends Controller
{

    public function getLayananForm()
    {
        $kategoriLayanans = KategoriLayanan::all(); // Mengambil semua kategori layanan dari database
        
        return view('reservasi.reservasi-clinic', ['title' => 'Reservasi Clinic'], compact('kategoriLayanans'));
    }

    public function chooseServiceCategory(Request $request)
    {
        try {
            $request->validate([
                'kategori_layanan_id' => ['required', 'string'],
            ]);
    
            // Simpan kategori layanan yang dipilih ke dalam session atau variabel sementara
            session(['selected_category' => $request->kategori_layanan_id]);
    
            // Ambil layanan berdasarkan kategori yang dipilih
            $layanans = Layanan::where('kategori_layanan_id', $request->kategori_layanan_id)->get();

            $userPets = Auth::user()->pets; // Mendapatkan semua hewan peliharaan milik pengguna
            
            return view('reservasi.formServiceAndPet',['title' => 'Reservasi Clinic'], compact('layanans', 'userPets'));
        }
        catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

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

            session(['selected_category' => $request->kategori_layanan_id]);

            // Retrieve the selected data from the session
            $selectedService = session('selected_service');
            $selectedPet = session('selected_pet');
            $selectedSchedule = $request->jadwal_klinik_id;

            $user = Auth::user();
            $userId = $user->user_id;

            // Fetch data from the JadwalKlinik table
            $jadwal = JadwalKlinik::findOrFail($selectedSchedule);
            $pekerjaId = $jadwal->pekerja_id;
            
            // Save the selected data into the transaksi table
            $transaksi = Transaksi::create([
                'jadwal_klinik_id' => $selectedSchedule,
                'layanan_id' => $selectedService,
                'user_id' => $userId,
                'pekerja_id' => $pekerjaId,
                'kode_pasien' => $selectedPet,
                'status' => 'Menunggu Pembayaran',
            ]);

            $expirationTime = now()->addMinutes(15);
            session(['transaksi_expiration_' . $transaksi->transaksi_id => $expirationTime->timestamp]);

            // Update the status in the jadwal_klinik table to "Dipesan"
            $jadwal->status = 'Dipesan';
            $jadwal->save();

            // Calculate total biaya
            $totalBiaya = $transaksi->layanan->biaya_booking + $transaksi->layanan->harga_layanan;

            // Update the total biaya in the transaksi table
            $transaksi->update(['total_biaya' => $totalBiaya]);


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

    public function showHalamanPembayaran($transaksi_id)
    {
        $transaksi = Transaksi::findOrFail($transaksi_id);

        // Check if the authenticated user owns the transaction
        $user = Auth::user();
        if ($user->user_id !== $transaksi->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('reservasi.halaman-transaksi', ['title' => 'Halaman Transaksi'], compact('transaksi'));
    }

    public function kirimBuktiPembayaran (Request $request, $transaksi_id)
    {
        try {

            $transaksi = Transaksi::findOrFail($transaksi_id);

            $request->validate([
                'bukti_transfer' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
            ]);

            $buktiPath = $transaksi->bukti_transfer;
            
            if ($request->hasFile('bukti_transfer')) {
                // Jika ada gambar baru diupload, hapus gambar lama
                Storage::delete('public/'.$transaksi->bukti_transfer);

                // Simpan gambar baru dan update path
                $buktiPath = $request->file('bukti_transfer')->store('bukti_pembayaran', 'public');
            } else {
                $buktiPath = null;
            }

            $transaksi->update([
                'bukti_transfer' => $buktiPath,
            ]);

            // Cek apakah waktu expiration telah habis
            $expirationTimestamp = session('transaksi_expiration_' . $transaksi->transaksi_id);
            $expirationTime = Carbon::parse($expirationTimestamp);
            $now = now();

            if ($now >= $expirationTime) {
                // Hapus session
                session()->forget('transaksi_expiration_' . $transaksi->transaksi_id);
    
                // Perbarui status transaksi menjadi "Expired"
                $transaksi->update(['status' => 'Expired']);
    
                // Perbarui status jadwal_transaksi menjadi "Aktif"
                $jadwal_transaksi = $transaksi->jadwal_transaksi;
                $jadwal_transaksi->update(['status' => 'Aktif']);
            }

            return redirect()->route('viewPets')->with('success', 'Bukti transfer berhasil diupload! Mohon tunggu konfirmasi dari Admin');
    
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}

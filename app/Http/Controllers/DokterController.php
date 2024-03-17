<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\Transaksi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function showJadwalAktif()
    {
        $title = 'Jadwal Aktif Dokter';

        $transaksi = Transaksi::whereHas('layanan', function ($query) {

            $query->where('kategori_layanan', 'Pet Clinic');
        })
        ->where('status', 'Pembayaran Berhasil')
        ->with('rekamMedis', 'JadwalKlinik.pekerja')
        ->get();

        return view('dokter.jadwal-aktif', compact('title', 'transaksi'));
    }

    public function tambahKeteranganDanMedikasi($transaksi_id)
    {
        $transaksi = Transaksi::findOrFail($transaksi_id);

        if (!$transaksi->jadwalKlinik || $transaksi->jadwalKlinik->pekerja_id === null) {
            abort(403, 'Tidak ada jadwal layanan pada transaksi.'); 
        }

        if ($transaksi->jadwalKlinik->pekerja_id != auth('pekerja')->user()->pekerja_id ||
            $transaksi->status !== 'Pembayaran Berhasil') {
                abort(403, 'Anda tidak punya akses.'); 
        }

        

        $rekamMedis = RekamMedis::where('transaksi_id', $transaksi_id)->first();

        $title = $rekamMedis ? 'Ubah Keterangan dan Medikasi' : 'Tambah Keterangan dan Medikasi';
    
        return view('dokter.tambah-keterangan-medikasi', compact('title', 'transaksi', 'rekamMedis'));
    }

    public function prosesTambahKeteranganDanMedikasi (Request $request): RedirectResponse
    {
        try {
            \Log::info($request->all());

            $request->validate([
                'transaksi_id' => ['required', 'string', 'max:15'],
                'pekerja_id' => ['required', 'string', 'max:10'],
                'kode_pasien' => ['required', 'string', 'max:6'],
                'keterangan_medis' => ['required', 'string'],
                'medikasi' => ['required', 'string'],
            ]);

            // Cari kategori_layanan_id berdasarkan nama_kategori
            // $kategori = KategoriLayanan::where('nama_kategori', $request->nama_kategori)->firstOrFail();

            RekamMedis::updateOrCreate(
                ['transaksi_id' => $request->transaksi_id],
                [
                    'pekerja_id' => $request->pekerja_id,
                    'kode_pasien' => $request->kode_pasien,
                    'keterangan_medis' => $request->keterangan_medis,
                    'medikasi' => $request->medikasi,
                ]
            );

            return redirect()->route('ShowJadwalAktif')->with('success', 'Rekam Medis Berhasil Diperbarui!');
        }
        catch (\Exception $e) {
            dd($e->getMessage());
            
        }

    }
}

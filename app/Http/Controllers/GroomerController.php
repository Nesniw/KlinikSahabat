<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class GroomerController extends Controller
{
    
    public function konfirmasiProsesGrooming()
    {
        $title = 'Konfirmasi Proses Grooming';

        $transaksi = Transaksi::whereHas('layanan', function ($query) {

            $query->where('kategori_layanan', 'Pet Grooming');
        })
        ->where('status', 'Pembayaran Berhasil')
        ->get();

        return view('groomer.konfirmasi-proses-grooming', compact('title', 'transaksi'));
    }

    public function konfirmasiSelesaiGrooming(Request $request, $transaction)
    {
        $transaksi = Transaksi::findOrFail($transaction);

        $transaksi->update(['status' => 'Proses Grooming Selesai']);

        $waktuSelesaiGrooming = $transaksi->updated_at->format('H:i');

        // Menyimpan nilai waktu dalam variabel sementara
        session(['waktu_selesai_grooming' => $waktuSelesaiGrooming]);

        return redirect()->route('KonfirmasiProsesGrooming')->with('success', 'Berhasil mengkonfirmasi status proses grooming!');
    }

}

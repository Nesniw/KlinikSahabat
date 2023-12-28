<?php

namespace App\Http\Controllers;
use App\Models\RekamMedis;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    //
    public function viewTransaksi()
    {
        $userTransaction = Auth::user()->transaksi;
        $title = 'My Transaksi';
    
        return view('mytransaksi.mytransaksi', compact('title', 'userTransaction'));
    }

    public function detailMyTransaksi($transaksi_id)
    {
        $title = 'My Transaksi - Detail';

        $transaksi = Transaksi::findOrFail($transaksi_id);

        return view('mytransaksi.detail-mytransaksi', compact('title','transaksi'));
    }

    public function detailPembayaran($transaksi_id)
    {
        $title = 'My Transaksi - Pembayaran';

        $transaksi = Transaksi::findOrFail($transaksi_id);

        return view('mytransaksi.detail-pembayaran', compact('title','transaksi'));
    }

    public function detailRekamMedis($transaksi_id)
    {
        $title = 'My Transaksi - Rekam Medis';

        $transaksi = Transaksi::findOrFail($transaksi_id);

        $rekamMedis = RekamMedis::where('transaksi_id', $transaksi_id)->first();

        return view('mytransaksi.detail-rekam-medis', compact('title','transaksi', 'rekamMedis'));
    }
}

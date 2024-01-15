<?php

namespace App\Http\Controllers;
use App\Models\RekamMedis;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;

class TransaksiController extends Controller
{
    //
    public function viewTransaksi(Request $request)
    {
        $userTransaction = Auth::user()->transaksi;
        $title = 'My Transaksi';

        // Ambil nilai filter status dari request
        $statusFilter = $request->input('statusFilter');

        // Filter transaksi berdasarkan status jika filter dipilih
        if ($statusFilter) {
            $userTransaction = $userTransaction->where('status', $statusFilter);
        }

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

    public function viewInvoice($transaksi_id)
    {
        $title = 'My Transaksi - Invoice';

        // Logika untuk mendapatkan data transaksi berdasarkan ID
        $transaksi = Transaksi::find($transaksi_id);

        // Membuat PDF
        $pdf = PDF::loadView('mytransaksi.invoice', compact('transaksi'));

        // Mengirimkan PDF untuk di-download
        return $pdf->stream('invoice.pdf');
    }
}

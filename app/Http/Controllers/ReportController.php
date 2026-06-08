<?php
namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Reservasi;
use App\Exports\ReservasiExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function adminPdf()
    {
        $reservasi       = Reservasi::with(['user', 'studio', 'pembayaran'])->latest()->get();
        $totalPendapatan = Pembayaran::where('status_bayar', 'lunas')->sum('jumlah');

        $pdf = Pdf::loadView('reports.reservasi-pdf', compact('reservasi', 'totalPendapatan'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-reservasi-' . date('Y-m-d') . '.pdf');
    }

    public function adminExcel()
    {
        return Excel::download(new ReservasiExport(), 'laporan-reservasi-' . date('Y-m-d') . '.xlsx');
    }

    public function ownerPdf()
    {
        $ownerId         = auth()->id();
        $reservasi       = Reservasi::with(['user', 'studio', 'pembayaran'])
            ->whereHas('studio', fn($q) => $q->where('id_owner', $ownerId))
            ->latest()->get();
        $totalPendapatan = $reservasi->sum('total_harga');

        $pdf = Pdf::loadView('reports.reservasi-pdf', compact('reservasi', 'totalPendapatan'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-reservasi-owner-' . date('Y-m-d') . '.pdf');
    }

    public function ownerExcel()
    {
        return Excel::download(new ReservasiExport(auth()->id()), 'laporan-reservasi-owner-' . date('Y-m-d') . '.xlsx');
    }
}
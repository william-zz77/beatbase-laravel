<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\Studio;
use App\Models\User;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudio    = Studio::count();
        $totalReservasi = Reservasi::count();
        $totalPending   = Reservasi::where('status', 'pending')->count();
        $totalCustomer  = User::where('role', 'customer')->count();
        $totalPendapatan = Pembayaran::where('status_bayar', 'lunas')->sum('jumlah');

        $recentReservasi = Reservasi::with(['user', 'studio'])
            ->latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalStudio', 'totalReservasi', 'totalPending',
            'totalCustomer', 'totalPendapatan', 'recentReservasi'
        ));
    }

    public function chartData()
    {
        // Chart 1: Reservasi per bulan (12 bulan terakhir)
        $reservasiPerBulan = Reservasi::selectRaw('MONTH(created_at) as bulan, YEAR(created_at) as tahun, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderByRaw('YEAR(created_at), MONTH(created_at)')
            ->get();

        $bulanLabel = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $dataReservasi = array_fill(0, 12, 0);
        foreach ($reservasiPerBulan as $r) {
            $dataReservasi[$r->bulan - 1] = $r->total;
        }

        // Chart 2: Pendapatan per studio
        $pendapatanPerStudio = Studio::withSum(['reservasi as total_pendapatan' => function($q) {
            $q->whereHas('pembayaran', fn($p) => $p->where('status_bayar', 'lunas'));
        }], 'total_harga')->get();

        return response()->json([
            'reservasi' => [
                'labels' => $bulanLabel,
                'data'   => $dataReservasi,
            ],
            'pendapatan' => [
                'labels' => $pendapatanPerStudio->pluck('nama_studio'),
                'data'   => $pendapatanPerStudio->pluck('total_pendapatan'),
            ],
        ]);
    }
}
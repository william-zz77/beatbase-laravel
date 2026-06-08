<?php
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\Studio;

class DashboardController extends Controller
{
    public function index()
    {
        $ownerId = auth()->id();

        $totalStudio    = Studio::milikOwner($ownerId)->count();
        $totalReservasi = Reservasi::whereHas('studio', fn($q) => $q->where('id_owner', $ownerId))->count();
        $totalPending   = Reservasi::whereHas('studio', fn($q) => $q->where('id_owner', $ownerId))->where('status', 'pending')->count();
        $totalPendapatan = Reservasi::whereHas('studio', fn($q) => $q->where('id_owner', $ownerId))
            ->whereHas('pembayaran', fn($q) => $q->where('status_bayar', 'lunas'))
            ->sum('total_harga');

        $recentReservasi = Reservasi::with(['user', 'studio'])
            ->whereHas('studio', fn($q) => $q->where('id_owner', $ownerId))
            ->latest()->limit(5)->get();

        return view('owner.dashboard', compact(
            'totalStudio', 'totalReservasi', 'totalPending',
            'totalPendapatan', 'recentReservasi'
        ));
    }

    public function chartData()
    {
        $ownerId = auth()->id();

        $reservasiPerBulan = Reservasi::whereHas('studio', fn($q) => $q->where('id_owner', $ownerId))
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->get();

        $bulanLabel = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $dataReservasi = array_fill(0, 12, 0);
        foreach ($reservasiPerBulan as $r) {
            $dataReservasi[$r->bulan - 1] = $r->total;
        }

        $pendapatanPerStudio = Studio::milikOwner($ownerId)
            ->withSum('reservasi as total_pendapatan', 'total_harga')->get();

        return response()->json([
            'reservasi' => ['labels' => $bulanLabel, 'data' => $dataReservasi],
            'pendapatan' => [
                'labels' => $pendapatanPerStudio->pluck('nama_studio'),
                'data'   => $pendapatanPerStudio->pluck('total_pendapatan'),
            ],
        ]);
    }
}
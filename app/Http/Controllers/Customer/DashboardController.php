<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\Studio;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $totalReservasi  = Reservasi::where('id_user', $userId)->count();
        $totalConfirmed  = Reservasi::where('id_user', $userId)->where('status', 'confirmed')->count();
        $totalPending    = Reservasi::where('id_user', $userId)->where('status', 'pending')->count();
        $totalPengeluaran = Reservasi::where('id_user', $userId)
            ->whereHas('pembayaran', fn($q) => $q->where('status_bayar', 'lunas'))
            ->sum('total_harga');

        $recentReservasi = Reservasi::with(['studio', 'pembayaran'])
            ->where('id_user', $userId)
            ->latest()->limit(5)->get();

        $studios = Studio::aktif()->limit(3)->get();

        return view('customer.dashboard', compact(
            'totalReservasi', 'totalConfirmed', 'totalPending',
            'totalPengeluaran', 'recentReservasi', 'studios'
        ));
    }
}
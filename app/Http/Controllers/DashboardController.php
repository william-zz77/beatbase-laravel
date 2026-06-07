<?php
namespace App\Http\Controllers;

use App\Models\Studio;
use App\Models\Reservasi;
use App\Models\User;
use App\Models\PengaturanJam;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin()
    {
        $data = [
            'totalStudio'    => Studio::count(),
            'totalReservasi' => Reservasi::count(),
            'totalPending'   => Reservasi::where('status','pending')->count(),
            'totalCustomer'  => User::where('role','customer')->count(),
            'recentReservasi'=> Reservasi::with(['user','studio'])->latest('created_at')->take(5)->get(),
            'jam'            => PengaturanJam::first(),
        ];
        return view('admin.dashboard', $data);
    }

    public function owner()
    {
        $data = [
            'totalStudio'    => Studio::count(),
            'totalReservasi' => Reservasi::count(),
            'totalConfirmed' => Reservasi::where('status','confirmed')->count(),
            'totalPending'   => Reservasi::where('status','pending')->count(),
            'recentReservasi'=> Reservasi::with(['user','studio'])->latest('created_at')->take(5)->get(),
            'studioList'     => Studio::all(),
            'jam'            => PengaturanJam::first(),
        ];
        return view('owner.dashboard', $data);
    }

    public function customer()
    {
        $userId = Auth::id();
        $data = [
            'totalMyRes' => Reservasi::where('id_user', $userId)->count(),
            'activeRes'  => Reservasi::where('id_user', $userId)->where('status','confirmed')->where('tanggal','>=',now()->toDateString())->count(),
            'myReservasi'=> Reservasi::with('studio')->where('id_user', $userId)->latest('tanggal')->take(5)->get(),
            'jam'        => PengaturanJam::first(),
        ];
        return view('customer.dashboard', $data);
    }
}
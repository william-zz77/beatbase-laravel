<?php
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\Studio;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function index(Request $request)
    {
        $ownerId = auth()->id();
        $query = Reservasi::with(['user', 'studio'])
            ->whereHas('studio', fn($q) => $q->where('id_owner', $ownerId));

        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('studio')) $query->where('id_studio', $request->studio);
        if ($request->filled('tanggal')) $query->whereDate('tanggal', $request->tanggal);

        $reservasi = $query->latest()->paginate(10)->withQueryString();
        $studios   = Studio::milikOwner($ownerId)->get();

        return view('owner.reservasi.index', compact('reservasi', 'studios'));
    }

    public function updateStatus(Request $request, Reservasi $reservasi)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,cancelled']);

        // Pastikan reservasi ini milik studio owner
        if ($reservasi->studio->id_owner !== auth()->id()) {
            return back()->with('error', 'Akses ditolak.');
        }

        $reservasi->update(['status' => $request->status]);
        return back()->with('success', 'Status reservasi berhasil diperbarui.');
    }
}
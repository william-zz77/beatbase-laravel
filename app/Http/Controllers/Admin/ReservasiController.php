<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\Studio;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservasi::with(['user', 'studio']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('studio')) {
            $query->where('id_studio', $request->studio);
        }
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $reservasi = $query->latest()->paginate(10)->withQueryString();
        $studios   = Studio::aktif()->get();

        return view('admin.reservasi.index', compact('reservasi', 'studios'));
    }

    public function updateStatus(Request $request, Reservasi $reservasi)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $reservasi->update(['status' => $request->status]);

        return back()->with('success', 'Status reservasi berhasil diperbarui.');
    }

    public function destroy(Reservasi $reservasi)
    {
        $reservasi->delete();
        return back()->with('success', 'Reservasi berhasil dihapus.');
    }
}
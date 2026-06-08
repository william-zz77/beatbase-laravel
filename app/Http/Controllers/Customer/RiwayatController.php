<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    public function index()
    {
        $reservasi = Reservasi::with(['studio', 'pembayaran'])
            ->where('id_user', auth()->id())
            ->latest()->paginate(10);

        return view('customer.riwayat', compact('reservasi'));
    }

    public function batal(Reservasi $reservasi)
    {
        if ($reservasi->id_user !== auth()->id()) {
            return back()->with('error', 'Akses ditolak.');
        }

        if ($reservasi->status !== 'pending') {
            return back()->with('error', 'Hanya reservasi pending yang bisa dibatalkan.');
        }

        // ── ACID Transaction ──────────────────────────────────────
        // Atomicity: update reservasi + update pembayaran dalam 1 unit
        // Isolation: lockForUpdate cegah race condition pembatalan
        try {
            DB::transaction(function () use ($reservasi) {

                $reservasi = Reservasi::where('id_reservasi', $reservasi->id_reservasi)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($reservasi->status !== 'pending') {
                    throw new \Exception('TIDAK_BISA_BATAL');
                }

                $reservasi->update(['status' => 'cancelled']);

                // Jika sudah ada pembayaran, set ke refund
                if ($reservasi->pembayaran) {
                    $reservasi->pembayaran->update(['status_bayar' => 'refund']);
                }

            }, 3);

            return back()->with('success', 'Reservasi berhasil dibatalkan.');

        } catch (\Exception $e) {
            if ($e->getMessage() === 'TIDAK_BISA_BATAL') {
                return back()->with('error', 'Reservasi ini tidak bisa dibatalkan.');
            }
            return back()->with('error', 'Gagal membatalkan reservasi. Coba lagi.');
        }
    }
}
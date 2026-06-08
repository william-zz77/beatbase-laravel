<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function show(Reservasi $reservasi)
    {
        if ($reservasi->id_user !== auth()->id()) {
            return redirect()->route('customer.riwayat.index')
                ->with('error', 'Akses ditolak.');
        }

        // Cek langsung ke DB - bypass Eloquent cache
        $statusBayar = DB::table('pembayaran')
            ->where('id_reservasi', $reservasi->id_reservasi)
            ->value('status_bayar');

        // Jika sudah lunas, redirect langsung
        if ($statusBayar === 'lunas') {
            return redirect()->route('customer.riwayat.index')
                ->with('error', 'Reservasi ini sudah lunas.');
        }

        // Jika reservasi dibatalkan
        if ($reservasi->status === 'cancelled') {
            return redirect()->route('customer.riwayat.index')
                ->with('error', 'Reservasi ini sudah dibatalkan.');
        }

        $reservasi->load('studio');

        return view('customer.pembayaran', compact('reservasi'));
    }

    public function store(Request $request, Reservasi $reservasi)
    {
        if ($reservasi->id_user !== auth()->id()) {
            return redirect()->route('customer.riwayat.index')
                ->with('error', 'Akses ditolak.');
        }

        if ($reservasi->status === 'cancelled') {
            return redirect()->route('customer.riwayat.index')
                ->with('error', 'Reservasi sudah dibatalkan.');
        }

        $request->validate([
            'metode_bayar' => 'required|in:transfer,tunai,ewallet',
        ], [
            'metode_bayar.required' => 'Metode pembayaran wajib dipilih.',
        ]);

        try {
            $berhasil = DB::transaction(function () use ($request, $reservasi) {

                // Query LANGSUNG ke DB dengan lock - bypass semua cache
                $statusBayar = DB::table('pembayaran')
                    ->where('id_reservasi', $reservasi->id_reservasi)
                    ->lockForUpdate()
                    ->value('status_bayar');

                // Jika sudah lunas, return false (bukan throw)
                if ($statusBayar === 'lunas') {
                    return false;
                }

                // Update atau insert pembayaran
                $exists = DB::table('pembayaran')
                    ->where('id_reservasi', $reservasi->id_reservasi)
                    ->exists();

                if ($exists) {
                    DB::table('pembayaran')
                        ->where('id_reservasi', $reservasi->id_reservasi)
                        ->update([
                            'metode_bayar' => $request->metode_bayar,
                            'status_bayar' => 'lunas',
                            'dibayar_at'   => now(),
                            'updated_at'   => now(),
                        ]);
                } else {
                    DB::table('pembayaran')->insert([
                        'id_reservasi' => $reservasi->id_reservasi,
                        'jumlah'       => $reservasi->total_harga,
                        'metode_bayar' => $request->metode_bayar,
                        'status_bayar' => 'lunas',
                        'dibayar_at'   => now(),
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ]);
                }

                DB::table('reservasi')
                    ->where('id_reservasi', $reservasi->id_reservasi)
                    ->update([
                        'status'     => 'confirmed',
                        'updated_at' => now(),
                    ]);

                return true;

            }, 3);

            // Jika return false berarti sudah lunas sebelumnya
            if ($berhasil === false) {
                return redirect()->route('customer.riwayat.index')
                    ->with('success', 'Reservasi ini sudah lunas sebelumnya.');
            }

            return redirect()->route('customer.riwayat.index')
                ->with('success', 'Pembayaran berhasil! Reservasi telah dikonfirmasi.');

        } catch (\Exception $e) {
            return redirect()->route('customer.riwayat.index')
                ->with('error', 'Pembayaran gagal: ' . $e->getMessage());
        }
    }
}
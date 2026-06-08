<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\PengaturanJam;
use App\Models\Reservasi;
use App\Models\Studio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $studios = Studio::aktif()->get();
        $jam     = PengaturanJam::getAktif();
        return view('customer.booking', compact('studios', 'jam'));
    }

    public function hitungHarga(Request $request)
    {
        $request->validate([
            'id_studio'   => 'required|exists:studio,id_studio',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
        ]);

        $studio  = Studio::findOrFail($request->id_studio);
        $mulai   = Carbon::parse($request->jam_mulai);
        $selesai = Carbon::parse($request->jam_selesai);
        $durasi  = $mulai->diffInMinutes($selesai) / 60;

        if ($durasi <= 0) {
            return response()->json(['error' => 'Jam selesai harus setelah jam mulai.'], 422);
        }

        $total = $durasi * $studio->harga_per_jam;

        return response()->json([
            'durasi'        => $durasi,
            'harga_per_jam' => $studio->harga_per_jam,
            'total'         => $total,
            'total_format'  => 'Rp ' . number_format($total, 0, ',', '.'),
        ]);
    }

    public function store(Request $request)
{
    $request->validate([
        'id_studio'   => 'required|exists:studio,id_studio',
        'tanggal'     => 'required|date|after_or_equal:today',
        'jam_mulai'   => 'required|date_format:H:i',
        'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        'catatan'     => 'nullable|string|max:500',
    ], [
        'tanggal.after_or_equal' => 'Tanggal tidak boleh di masa lalu.',
        'jam_selesai.after'      => 'Jam selesai harus setelah jam mulai.',
    ]);

    $studio  = Studio::findOrFail($request->id_studio);
    $mulai   = Carbon::parse($request->jam_mulai);
    $selesai = Carbon::parse($request->jam_selesai);
    $durasi  = $mulai->diffInMinutes($selesai) / 60;
    $total   = $durasi * $studio->harga_per_jam;

    // Validasi jam tidak boleh lewat untuk hari ini
    $now = Carbon::now('Asia/Jakarta');
    if ($request->tanggal === $now->format('Y-m-d')) {
        if ($mulai->hour <= $now->hour) {
            return back()->withInput()
                ->with('error', 'Jam mulai sudah lewat. Pilih jam yang belum lewat untuk hari ini.');
        }
    }

    // Definisikan variabel jam di sini agar bisa dipakai di dalam closure
    $jamMulai   = $request->jam_mulai . ':00';
    $jamSelesai = $request->jam_selesai . ':00';
    $idStudio   = $request->id_studio;
    $tanggal    = $request->tanggal;

    try {
        DB::transaction(function () use ($request, $total, $jamMulai, $jamSelesai, $idStudio, $tanggal) {

            // Cek bentrok dengan lockForUpdate
            $bentrok = Reservasi::where('id_studio', $idStudio)
                ->where('tanggal', $tanggal)
                ->where('status', '!=', 'cancelled')
                ->where('jam_mulai', '<', $jamSelesai)
                ->where('jam_selesai', '>', $jamMulai)
                ->lockForUpdate()
                ->exists();

            if ($bentrok) {
                throw new \Exception('BENTROK');
            }

            $reservasi = Reservasi::create([
                'id_user'     => auth()->id(),
                'id_studio'   => $idStudio,
                'tanggal'     => $tanggal,
                'jam_mulai'   => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'total_harga' => $total,
                'status'      => 'pending',
                'catatan'     => $request->catatan,
            ]);

            $reservasi->pembayaran()->create([
                'jumlah'       => $total,
                'metode_bayar' => 'transfer',
                'status_bayar' => 'belum_bayar',
            ]);

        }, 3);

        return redirect()->route('customer.riwayat.index')
            ->with('success', 'Booking berhasil! Silakan lakukan pembayaran.');

    } catch (\Exception $e) {
        if ($e->getMessage() === 'BENTROK') {
            return back()->withInput()
                ->with('error', 'Jadwal bentrok! Studio sudah dibooking pada waktu tersebut.');
        }
        return back()->withInput()
            ->with('error', 'Booking gagal: ' . $e->getMessage());
    }
}
}
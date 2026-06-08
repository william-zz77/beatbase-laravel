<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\PengaturanJam;
use App\Models\Reservasi;
use App\Models\Studio;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $studios        = Studio::aktif()->get();
        $selectedStudio = (int)($request->studio ?? 0);
        $weekOffset     = (int)($request->week ?? 0);

        $now    = Carbon::now('Asia/Jakarta');
        $monday = Carbon::now('Asia/Jakarta')->startOfWeek()->addWeeks($weekOffset);

        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $days[] = $monday->copy()->addDays($i);
        }

        $jam      = PengaturanJam::getAktif();
        $jamBuka  = (int)substr($jam->jam_buka, 0, 2);
        $jamTutup = (int)substr($jam->jam_tutup, 0, 2);

        $reservasiMinggu = [];
        if ($selectedStudio > 0) {
            $tglMulai = $days[0]->format('Y-m-d');
            $tglAkhir = $days[6]->format('Y-m-d');

            $reservasi = Reservasi::where('id_studio', $selectedStudio)
                ->whereBetween('tanggal', [$tglMulai, $tglAkhir])
                ->where('status', '!=', 'cancelled')
                ->get(['tanggal', 'jam_mulai', 'jam_selesai']);

            foreach ($reservasi as $r) {
                $tgl     = Carbon::parse($r->tanggal)->format('Y-m-d');
                $mulai   = Carbon::parse($tgl . ' ' . $r->jam_mulai);
                $selesai = Carbon::parse($tgl . ' ' . $r->jam_selesai);

                for ($h = $jamBuka; $h < $jamTutup; $h++) {
                    $slotMulai   = Carbon::parse($tgl . ' ' . sprintf('%02d:00:00', $h));
                    $slotSelesai = Carbon::parse($tgl . ' ' . sprintf('%02d:00:00', $h + 1));

                    if ($mulai->lt($slotSelesai) && $selesai->gt($slotMulai)) {
                        $reservasiMinggu[$tgl][$h] = true;
                    }
                }
            }
        }

        return view('customer.jadwal', compact(
            'studios', 'selectedStudio', 'weekOffset',
            'days', 'jamBuka', 'jamTutup', 'reservasiMinggu', 'now'
        ));
    }
}
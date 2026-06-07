<?php
namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Studio;
use App\Models\PengaturanJam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservasi::with(['user','studio']);
        if ($request->status) $query->where('status', $request->status);
        if ($request->studio) $query->where('id_studio', $request->studio);
        if ($request->tanggal) $query->where('tanggal', $request->tanggal);

        $role = Auth::user()->role;
        if ($role === 'customer') {
            $query->where('id_user', Auth::id());
        }

        $reservasiList = $query->orderBy('tanggal','desc')->get();
        $studioList    = Studio::orderBy('nama_studio')->get();

        $view = match($role) {
            'admin'    => 'admin.reservasi',
            'owner'    => 'owner.reservasi',
            default    => 'customer.reservasi',
        };
        return view($view, compact('reservasiList','studioList'));
    }

    public function create()
    {
        $studios = Studio::orderBy('nama_studio')->get();
        $jam     = PengaturanJam::first();
        return view('customer.booking', compact('studios','jam'));
    }

    public function store(Request $request)
    {
        $jam     = PengaturanJam::first();
        $jamBuka = $jam ? substr($jam->jam_buka, 0, 5) : '09:00';
        $jamTutup= $jam ? substr($jam->jam_tutup, 0, 5) : '22:00';

        $request->validate([
            'id_studio'   => 'required|exists:studio,id_studio',
            'tanggal'     => 'required|date|after_or_equal:today',
            'jam_mulai'   => "required|date_format:H:i|after_or_equal:$jamBuka",
            'jam_selesai' => "required|date_format:H:i|before_or_equal:$jamTutup|after:jam_mulai",
        ]);

        // Cek bentrok jadwal
        $bentrok = Reservasi::where('id_studio', $request->id_studio)
            ->where('tanggal', $request->tanggal)
            ->where('status','!=','cancelled')
            ->where('jam_mulai','<', $request->jam_selesai)
            ->where('jam_selesai','>', $request->jam_mulai)
            ->exists();

        if ($bentrok) {
            return back()->withErrors(['jam_mulai' => '⚠️ Jadwal bentrok! Studio sudah dipesan pada jam tersebut.'])->withInput();
        }

        Reservasi::create([
            'id_user'    => Auth::id(),
            'id_studio'  => $request->id_studio,
            'tanggal'    => $request->tanggal,
            'jam_mulai'  => $request->jam_mulai,
            'jam_selesai'=> $request->jam_selesai,
            'status'     => 'pending',
        ]);

        return back()->with('success','✅ Booking berhasil! Menunggu konfirmasi dari admin.');
    }

    public function update(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $request->validate(['status' => 'required|in:pending,confirmed,cancelled']);
        $reservasi->update(['status' => $request->status]);
        return back()->with('success','Status reservasi berhasil diperbarui!');
    }

    public function jadwal(Request $request)
    {
        $studios        = Studio::orderBy('nama_studio')->get();
        $jam            = PengaturanJam::first();
        $selectedStudio = $request->studio;
        $weekOffset     = (int)($request->week ?? 0);

        $monday = now()->startOfWeek()->addWeeks($weekOffset);
        $days   = collect(range(0,6))->map(fn($i) => $monday->copy()->addDays($i));

        $reservasiMinggu = [];
        if ($selectedStudio) {
            $res = Reservasi::where('id_studio', $selectedStudio)
                ->whereBetween('tanggal', [$days->first()->toDateString(), $days->last()->toDateString()])
                ->where('status','!=','cancelled')
                ->get();
            foreach ($res as $r) {
                $mulai   = (int)substr($r->jam_mulai, 0, 2);
                $selesai = (int)substr($r->jam_selesai, 0, 2);
                for ($h = $mulai; $h < $selesai; $h++) {
                    $reservasiMinggu[$r->tanggal][$h] = true;
                }
            }
        }

        return view('customer.jadwal', compact('studios','jam','selectedStudio','weekOffset','days','reservasiMinggu','monday'));
    }
}
<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanJam;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $jam = PengaturanJam::getAktif();
        return view('admin.pengaturan.index', compact('jam'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'jam_buka'  => 'required|date_format:H:i',
            'jam_tutup' => 'required|date_format:H:i|after:jam_buka',
        ], [
            'jam_buka.required'   => 'Jam buka wajib diisi.',
            'jam_tutup.required'  => 'Jam tutup wajib diisi.',
            'jam_tutup.after'     => 'Jam tutup harus setelah jam buka.',
        ]);

        $jam = PengaturanJam::getAktif();
        $jam->update([
            'jam_buka'  => $request->jam_buka . ':00',
            'jam_tutup' => $request->jam_tutup . ':00',
        ]);

        return back()->with('success', 'Pengaturan jam operasional berhasil disimpan.');
    }
}
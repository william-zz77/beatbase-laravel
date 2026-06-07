<?php

namespace App\Http\Controllers;

use App\Models\PengaturanJam;
use Illuminate\Http\Request;

class PengaturanJamController extends Controller
{
    public function index()
    {
        $pengaturan = PengaturanJam::first();
        return view('admin.pengaturan_jam', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'jam_buka'   => 'required',
            'jam_tutup'  => 'required|after:jam_buka',
        ]);

        $pengaturan = PengaturanJam::first();

        if ($pengaturan) {
            $pengaturan->update($request->only('jam_buka', 'jam_tutup'));
        } else {
            PengaturanJam::create($request->only('jam_buka', 'jam_tutup'));
        }

        return back()->with('success', 'Jam operasional berhasil diperbarui!');
    }
}
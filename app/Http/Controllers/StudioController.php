<?php
namespace App\Http\Controllers;

use App\Models\Studio;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    public function index()
    {
        $studios = Studio::all();
        return view('admin.studio', compact('studios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_studio'   => 'required|string|max:100',
            'harga_per_jam' => 'required|numeric|min:1000',
        ]);
        Studio::create($request->only('nama_studio','harga_per_jam'));
        return back()->with('success','Studio berhasil ditambahkan!');
    }

    public function edit(Studio $studio)
    {
        $studios  = Studio::all();
        $editData = $studio;
        return view('admin.studio', compact('studios','editData'));
    }

    public function update(Request $request, Studio $studio)
    {
        $request->validate([
            'nama_studio'   => 'required|string|max:100',
            'harga_per_jam' => 'required|numeric|min:1000',
        ]);
        $studio->update($request->only('nama_studio','harga_per_jam'));
        return redirect()->route('admin.studio.index')->with('success','Studio berhasil diperbarui!');
    }

    public function destroy(Studio $studio)
    {
        $aktif = Reservasi::where('id_studio', $studio->id_studio)->where('status','!=','cancelled')->count();
        if ($aktif > 0) {
            return back()->with('error','Studio tidak bisa dihapus karena masih ada reservasi aktif!');
        }
        $studio->delete();
        return back()->with('success','Studio berhasil dihapus!');
    }
}
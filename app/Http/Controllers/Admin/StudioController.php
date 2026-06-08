<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use App\Models\User;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    public function index()
    {
        $studios = Studio::with('owner')->latest()->paginate(10);
        return view('admin.studio.index', compact('studios'));
    }

    public function create()
    {
        $owners = User::where('role', 'owner')->get();
        return view('admin.studio.create', compact('owners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_studio'  => 'required|string|max:100',
            'deskripsi'    => 'nullable|string',
            'harga_per_jam'=> 'required|numeric|min:1000',
            'id_owner'     => 'nullable|exists:users,id_user',
            'is_active'    => 'boolean',
        ], [
            'nama_studio.required'  => 'Nama studio wajib diisi.',
            'harga_per_jam.required'=> 'Harga per jam wajib diisi.',
            'harga_per_jam.numeric' => 'Harga per jam harus berupa angka.',
            'harga_per_jam.min'     => 'Harga per jam minimal Rp 1.000.',
        ]);

        Studio::create([
            'nama_studio'  => $request->nama_studio,
            'deskripsi'    => $request->deskripsi,
            'harga_per_jam'=> $request->harga_per_jam,
            'id_owner'     => $request->id_owner,
            'is_active'    => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.studio.index')
            ->with('success', 'Studio berhasil ditambahkan.');
    }

    public function edit(Studio $studio)
    {
        $owners = User::where('role', 'owner')->get();
        return view('admin.studio.edit', compact('studio', 'owners'));
    }

    public function update(Request $request, Studio $studio)
    {
        $request->validate([
            'nama_studio'  => 'required|string|max:100',
            'deskripsi'    => 'nullable|string',
            'harga_per_jam'=> 'required|numeric|min:1000',
            'id_owner'     => 'nullable|exists:users,id_user',
        ]);

        $studio->update([
            'nama_studio'  => $request->nama_studio,
            'deskripsi'    => $request->deskripsi,
            'harga_per_jam'=> $request->harga_per_jam,
            'id_owner'     => $request->id_owner,
            'is_active'    => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.studio.index')
            ->with('success', 'Studio berhasil diperbarui.');
    }

    public function destroy(Studio $studio)
    {
        $studio->delete();
        return redirect()->route('admin.studio.index')
            ->with('success', 'Studio berhasil dihapus.');
    }

    public function show(Studio $studio)
    {
        return redirect()->route('admin.studio.index');
    }
}
<?php
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    public function index()
    {
        $studios = Studio::milikOwner(auth()->id())->latest()->paginate(10);
        return view('owner.studio.index', compact('studios'));
    }

    public function create()
    {
        return view('owner.studio.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_studio'   => 'required|string|max:100',
            'deskripsi'     => 'nullable|string',
            'harga_per_jam' => 'required|numeric|min:1000',
        ], [
            'nama_studio.required'   => 'Nama studio wajib diisi.',
            'harga_per_jam.required' => 'Harga per jam wajib diisi.',
            'harga_per_jam.min'      => 'Harga minimal Rp 1.000.',
        ]);

        Studio::create([
            'id_owner'      => auth()->id(),
            'nama_studio'   => $request->nama_studio,
            'deskripsi'     => $request->deskripsi,
            'harga_per_jam' => $request->harga_per_jam,
            'is_active'     => $request->boolean('is_active', true),
        ]);

        return redirect()->route('owner.studio.index')
            ->with('success', 'Studio berhasil ditambahkan.');
    }

    public function edit(Studio $studio)
    {
        // Pastikan owner hanya bisa edit studio miliknya
        if ($studio->id_owner !== auth()->id()) {
            return redirect()->route('owner.studio.index')
                ->with('error', 'Anda tidak memiliki akses ke studio ini.');
        }
        return view('owner.studio.edit', compact('studio'));
    }

    public function update(Request $request, Studio $studio)
    {
        if ($studio->id_owner !== auth()->id()) {
            return redirect()->route('owner.studio.index')
                ->with('error', 'Anda tidak memiliki akses ke studio ini.');
        }

        $request->validate([
            'nama_studio'   => 'required|string|max:100',
            'deskripsi'     => 'nullable|string',
            'harga_per_jam' => 'required|numeric|min:1000',
        ]);

        $studio->update([
            'nama_studio'   => $request->nama_studio,
            'deskripsi'     => $request->deskripsi,
            'harga_per_jam' => $request->harga_per_jam,
            'is_active'     => $request->boolean('is_active', true),
        ]);

        return redirect()->route('owner.studio.index')
            ->with('success', 'Studio berhasil diperbarui.');
    }

    public function destroy(Studio $studio)
    {
        if ($studio->id_owner !== auth()->id()) {
            return redirect()->route('owner.studio.index')
                ->with('error', 'Anda tidak memiliki akses ke studio ini.');
        }
        $studio->delete();
        return redirect()->route('owner.studio.index')
            ->with('success', 'Studio berhasil dihapus.');
    }

    public function show(Studio $studio)
    {
        return redirect()->route('owner.studio.index');
    }
}
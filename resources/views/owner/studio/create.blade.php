@extends('layouts.app')
@section('title', 'Tambah Studio')
@section('page-title', 'Tambah Studio')
@section('sidebar-nav')
<a href="{{ route('owner.dashboard') }}" class="nav-link">Dashboard</a>
<a href="{{ route('owner.studio.index') }}" class="nav-link active">Studio Saya</a>
<a href="{{ route('owner.reservasi.index') }}" class="nav-link">Reservasi</a>
@endsection

@section('content')
<div class="max-w-2xl"><div class="card p-6">
<form action="{{ route('owner.studio.store') }}" method="POST">
@csrf
<div class="mb-4">
    <label class="block text-sm font-medium text-slate-300 mb-1.5">Nama Studio</label>
    <input type="text" name="nama_studio" value="{{ old('nama_studio') }}" class="form-input" placeholder="Nama studio">
    @error('nama_studio')<p class="mt-1 text-red-400 text-xs">{{ $message }}</p>@enderror
</div>
<div class="mb-4">
    <label class="block text-sm font-medium text-slate-300 mb-1.5">Deskripsi</label>
    <textarea name="deskripsi" rows="3" class="form-input">{{ old('deskripsi') }}</textarea>
</div>
<div class="mb-4">
    <label class="block text-sm font-medium text-slate-300 mb-1.5">Harga per Jam (Rp)</label>
    <input type="number" name="harga_per_jam" value="{{ old('harga_per_jam') }}" class="form-input" placeholder="75000">
    @error('harga_per_jam')<p class="mt-1 text-red-400 text-xs">{{ $message }}</p>@enderror
</div>
<div class="mb-6">
    <label class="flex items-center gap-2 cursor-pointer">
        <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 accent-violet-500">
        <span class="text-sm text-slate-300">Studio aktif</span>
    </label>
</div>
<div class="flex gap-3">
    <button type="submit" class="btn btn-violet">Simpan</button>
    <a href="{{ route('owner.studio.index') }}" class="btn btn-ghost">Batal</a>
</div>
</form>
</div></div>
@endsection
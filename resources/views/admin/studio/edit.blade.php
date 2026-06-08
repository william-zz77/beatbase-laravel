@extends('layouts.app')
@section('title', 'Edit Studio')
@section('page-title', 'Edit Studio')
@section('sidebar-nav') @include('admin.partials.sidebar') @endsection

@section('content')
<div class="max-w-2xl">
<div class="card p-6">
    <form action="{{ route('admin.studio.update', $studio) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-4">
        <label class="block text-sm font-medium text-slate-300 mb-1.5">Nama Studio</label>
        <input type="text" name="nama_studio" value="{{ old('nama_studio', $studio->nama_studio) }}"
            class="form-input {{ $errors->has('nama_studio') ? 'border-red-500' : '' }}">
        @error('nama_studio')<p class="mt-1 text-red-400 text-xs">{{ $message }}</p>@enderror
    </div>
    <div class="mb-4">
        <label class="block text-sm font-medium text-slate-300 mb-1.5">Deskripsi</label>
        <textarea name="deskripsi" rows="3" class="form-input">{{ old('deskripsi', $studio->deskripsi) }}</textarea>
    </div>
    <div class="mb-4">
        <label class="block text-sm font-medium text-slate-300 mb-1.5">Harga per Jam (Rp)</label>
        <input type="number" name="harga_per_jam" value="{{ old('harga_per_jam', $studio->harga_per_jam) }}"
            class="form-input {{ $errors->has('harga_per_jam') ? 'border-red-500' : '' }}">
        @error('harga_per_jam')<p class="mt-1 text-red-400 text-xs">{{ $message }}</p>@enderror
    </div>
    <div class="mb-4">
        <label class="block text-sm font-medium text-slate-300 mb-1.5">Owner</label>
        <select name="id_owner" class="form-input">
            <option value="">-- Pilih Owner --</option>
            @foreach($owners as $owner)
            <option value="{{ $owner->id_user }}" {{ old('id_owner', $studio->id_owner) == $owner->id_user ? 'selected' : '' }}>
                {{ $owner->nama }} ({{ $owner->email }})
            </option>
            @endforeach
        </select>
    </div>
    <div class="mb-6">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $studio->is_active) ? 'checked' : '' }}
                class="w-4 h-4 rounded accent-violet-500">
            <span class="text-sm text-slate-300">Studio aktif</span>
        </label>
    </div>
    <div class="flex gap-3">
        <button type="submit" class="btn btn-violet">Perbarui Studio</button>
        <a href="{{ route('admin.studio.index') }}" class="btn btn-ghost">Batal</a>
    </div>
    </form>
</div>
</div>
@endsection
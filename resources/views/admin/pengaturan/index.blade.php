@extends('layouts.app')
@section('title', 'Pengaturan Jam')
@section('page-title', 'Pengaturan Jam Operasional')
@section('sidebar-nav') @include('admin.partials.sidebar') @endsection

@section('content')
<div class="max-w-md"><div class="card p-6">
<form action="{{ route('admin.pengaturan.update') }}" method="POST">
@csrf @method('PUT')
<div class="mb-4">
    <label class="block text-sm font-medium text-slate-300 mb-1.5">Jam Buka</label>
    <input type="time" name="jam_buka" value="{{ substr($jam->jam_buka, 0, 5) }}" class="form-input">
    @error('jam_buka')<p class="mt-1 text-red-400 text-xs">{{ $message }}</p>@enderror
</div>
<div class="mb-6">
    <label class="block text-sm font-medium text-slate-300 mb-1.5">Jam Tutup</label>
    <input type="time" name="jam_tutup" value="{{ substr($jam->jam_tutup, 0, 5) }}" class="form-input">
    @error('jam_tutup')<p class="mt-1 text-red-400 text-xs">{{ $message }}</p>@enderror
</div>
<button type="submit" class="btn btn-violet">Simpan Pengaturan</button>
</form>
</div></div>
@endsection
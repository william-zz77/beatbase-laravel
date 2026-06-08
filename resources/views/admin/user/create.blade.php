@extends('layouts.app')
@section('title', 'Tambah User')
@section('page-title', 'Tambah User')
@section('sidebar-nav') @include('admin.partials.sidebar') @endsection

@section('content')
<div class="max-w-2xl"><div class="card p-6">
<form action="{{ route('admin.user.store') }}" method="POST">
@csrf
<div class="mb-4">
    <label class="block text-sm font-medium text-slate-300 mb-1.5">Nama</label>
    <input type="text" name="nama" value="{{ old('nama') }}" class="form-input" placeholder="Nama lengkap">
    @error('nama')<p class="mt-1 text-red-400 text-xs">{{ $message }}</p>@enderror
</div>
<div class="mb-4">
    <label class="block text-sm font-medium text-slate-300 mb-1.5">Email</label>
    <input type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="email@example.com">
    @error('email')<p class="mt-1 text-red-400 text-xs">{{ $message }}</p>@enderror
</div>
<div class="mb-4">
    <label class="block text-sm font-medium text-slate-300 mb-1.5">Password</label>
    <input type="password" name="password" class="form-input" placeholder="Min. 6 karakter">
    @error('password')<p class="mt-1 text-red-400 text-xs">{{ $message }}</p>@enderror
</div>
<div class="mb-6">
    <label class="block text-sm font-medium text-slate-300 mb-1.5">Role</label>
    <select name="role" class="form-input">
        <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>Customer</option>
        <option value="owner"    {{ old('role') === 'owner'    ? 'selected' : '' }}>Owner</option>
        <option value="admin"    {{ old('role') === 'admin'    ? 'selected' : '' }}>Admin</option>
    </select>
    @error('role')<p class="mt-1 text-red-400 text-xs">{{ $message }}</p>@enderror
</div>
<div class="flex gap-3">
    <button type="submit" class="btn btn-violet">Simpan User</button>
    <a href="{{ route('admin.user.index') }}" class="btn btn-ghost">Batal</a>
</div>
</form>
</div></div>
@endsection
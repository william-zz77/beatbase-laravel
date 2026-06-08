@extends('layouts.app')
@section('title', 'Edit User')
@section('page-title', 'Edit User')
@section('sidebar-nav') @include('admin.partials.sidebar') @endsection

@section('content')
<div class="max-w-2xl"><div class="card p-6">
<form action="{{ route('admin.user.update', $user) }}" method="POST">
@csrf @method('PUT')
<div class="mb-4">
    <label class="block text-sm font-medium text-slate-300 mb-1.5">Nama</label>
    <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="form-input">
    @error('nama')<p class="mt-1 text-red-400 text-xs">{{ $message }}</p>@enderror
</div>
<div class="mb-4">
    <label class="block text-sm font-medium text-slate-300 mb-1.5">Email</label>
    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input">
    @error('email')<p class="mt-1 text-red-400 text-xs">{{ $message }}</p>@enderror
</div>
<div class="mb-4">
    <label class="block text-sm font-medium text-slate-300 mb-1.5">Password Baru <span class="text-slate-500">(kosongkan jika tidak ingin mengubah)</span></label>
    <input type="password" name="password" class="form-input" placeholder="Kosongkan jika tidak diubah">
</div>
<div class="mb-6">
    <label class="block text-sm font-medium text-slate-300 mb-1.5">Role</label>
    <select name="role" class="form-input">
        <option value="customer" {{ old('role', $user->role) === 'customer' ? 'selected' : '' }}>Customer</option>
        <option value="owner"    {{ old('role', $user->role) === 'owner'    ? 'selected' : '' }}>Owner</option>
        <option value="admin"    {{ old('role', $user->role) === 'admin'    ? 'selected' : '' }}>Admin</option>
    </select>
</div>
<div class="flex gap-3">
    <button type="submit" class="btn btn-violet">Perbarui User</button>
    <a href="{{ route('admin.user.index') }}" class="btn btn-ghost">Batal</a>
</div>
</form>
</div></div>
@endsection
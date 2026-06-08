@extends('layouts.app')
@section('title', 'Studio Saya')
@section('page-title', 'Studio Saya')
@section('sidebar-nav')
<a href="{{ route('owner.dashboard') }}" class="nav-link">Dashboard</a>
<a href="{{ route('owner.studio.index') }}" class="nav-link active">Studio Saya</a>
<a href="{{ route('owner.reservasi.index') }}" class="nav-link">Reservasi</a>
@endsection
@section('topbar-actions')
<a href="{{ route('owner.studio.create') }}" class="btn btn-violet">+ Tambah Studio</a>
@endsection

@section('content')
<div class="card">
    <table>
        <thead><tr><th>No</th><th>Nama Studio</th><th>Harga/Jam</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @forelse($studios as $i => $studio)
            <tr>
                <td class="text-slate-500">{{ $studios->firstItem() + $i }}</td>
                <td><p class="text-white font-medium">{{ $studio->nama_studio }}</p><p class="text-xs text-slate-500">{{ Str::limit($studio->deskripsi,50) }}</p></td>
                <td class="text-slate-300">Rp {{ number_format($studio->harga_per_jam,0,',','.') }}</td>
                <td><span class="badge {{ $studio->is_active ? 'badge-confirmed' : 'badge-cancelled' }}">{{ $studio->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                <td>
                    <div class="flex gap-2">
                        <a href="{{ route('owner.studio.edit', $studio) }}" class="btn btn-ghost btn-sm">Edit</a>
                        <button onclick="confirmDelete('{{ route('owner.studio.destroy', $studio) }}')" class="btn btn-danger btn-sm">Hapus</button>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-slate-500 py-8">Belum ada studio</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $studios->links() }}</div>
</div>
@endsection
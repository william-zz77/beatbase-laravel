@extends('layouts.app')
@section('title', 'Kelola Studio')
@section('page-title', 'Kelola Studio')
@section('page-subtitle', 'Daftar semua studio yang terdaftar')

@section('sidebar-nav')
@include('admin.partials.sidebar')
@endsection

@section('topbar-actions')
<a href="{{ route('admin.studio.create') }}" class="btn btn-violet">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    Tambah Studio
</a>
@endsection

@section('content')
<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Studio</th>
                <th>Owner</th>
                <th>Harga/Jam</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($studios as $i => $studio)
            <tr>
                <td class="text-slate-500">{{ $studios->firstItem() + $i }}</td>
                <td>
                    <p class="text-white font-medium">{{ $studio->nama_studio }}</p>
                    <p class="text-slate-500 text-xs">{{ Str::limit($studio->deskripsi, 50) }}</p>
                </td>
                <td class="text-slate-300">{{ $studio->owner->nama ?? '-' }}</td>
                <td class="text-slate-300">Rp {{ number_format($studio->harga_per_jam, 0, ',', '.') }}</td>
                <td>
                    <span class="badge {{ $studio->is_active ? 'badge-confirmed' : 'badge-cancelled' }}">
                        {{ $studio->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.studio.edit', $studio) }}" class="btn btn-ghost btn-sm">Edit</a>
                        <button onclick="confirmDelete('{{ route('admin.studio.destroy', $studio) }}', 'Hapus studio {{ $studio->nama_studio }}?')"
                            class="btn btn-danger btn-sm">Hapus</button>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-slate-500 py-8">Belum ada studio</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $studios->links() }}</div>
</div>
@endsection
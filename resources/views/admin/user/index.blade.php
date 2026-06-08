@extends('layouts.app')
@section('title', 'Kelola User')
@section('page-title', 'Kelola User')
@section('sidebar-nav') @include('admin.partials.sidebar') @endsection
@section('topbar-actions')
<a href="{{ route('admin.user.create') }}" class="btn btn-violet">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    Tambah User
</a>
@endsection

@section('content')
<div class="card">
    <table>
        <thead>
            <tr><th>No</th><th>Nama</th><th>Email</th><th>Role</th><th>Bergabung</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @forelse($users as $i => $user)
            <tr>
                <td class="text-slate-500">{{ $users->firstItem() + $i }}</td>
                <td>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-violet-600/30 flex items-center justify-center shrink-0">
                            <span class="text-xs font-bold text-violet-300">{{ strtoupper(substr($user->nama,0,2)) }}</span>
                        </div>
                        <span class="text-white font-medium">{{ $user->nama }}</span>
                    </div>
                </td>
                <td class="text-slate-400">{{ $user->email }}</td>
                <td>
                    <span class="badge {{ $user->role === 'admin' ? 'badge-cancelled' : ($user->role === 'owner' ? 'badge-pending' : 'badge-confirmed') }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td class="text-slate-400">{{ $user->created_at->format('d M Y') }}</td>
                <td>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-ghost btn-sm">Edit</a>
                        @if($user->id_user !== auth()->id())
                        <button onclick="confirmDelete('{{ route('admin.user.destroy', $user) }}', 'Hapus user {{ $user->nama }}?')"
                            class="btn btn-danger btn-sm">Hapus</button>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-slate-500 py-8">Belum ada user</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $users->links() }}</div>
</div>
@endsection
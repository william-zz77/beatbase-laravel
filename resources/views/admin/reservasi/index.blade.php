@extends('layouts.app')
@section('title', 'Kelola Reservasi')
@section('page-title', 'Kelola Reservasi')
@section('sidebar-nav') @include('admin.partials.sidebar') @endsection

@section('content')
{{-- Filter --}}
<div class="card p-4 mb-4">
    <form method="GET" class="flex gap-3 flex-wrap">
        <select name="status" class="form-input w-auto">
            <option value="">Semua Status</option>
            <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        <select name="studio" class="form-input w-auto">
            <option value="">Semua Studio</option>
            @foreach($studios as $s)
            <option value="{{ $s->id_studio }}" {{ request('studio') == $s->id_studio ? 'selected' : '' }}>
                {{ $s->nama_studio }}
            </option>
            @endforeach
        </select>
        <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-input w-auto">
        <button type="submit" class="btn btn-violet">Filter</button>
        <a href="{{ route('admin.reservasi.index') }}" class="btn btn-ghost">Reset</a>
    </form>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Customer</th>
                <th>Studio</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservasi as $r)
            <tr>
                <td>
                    <p class="text-white font-medium">{{ $r->user->nama }}</p>
                    <p class="text-xs text-slate-500">{{ $r->user->email }}</p>
                </td>
                <td class="text-slate-300">{{ $r->studio->nama_studio }}</td>
                <td class="text-slate-300">{{ $r->tanggal->format('d M Y') }}</td>
                <td class="text-slate-300">{{ substr($r->jam_mulai,0,5) }} - {{ substr($r->jam_selesai,0,5) }}</td>
                <td class="text-slate-300">Rp {{ number_format($r->total_harga,0,',','.') }}</td>
                <td><span class="badge {{ $r->status_badge }}">{{ $r->status_label }}</span></td>
                <td>
                    <div class="flex items-center gap-2">
                        <form method="POST" action="{{ route('admin.reservasi.status', $r->id_reservasi) }}">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="form-input w-auto text-xs py-1">
                                <option value="pending"   {{ $r->status === 'pending'   ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $r->status === 'confirmed' ? 'selected' : '' }}>Konfirmasi</option>
                                <option value="cancelled" {{ $r->status === 'cancelled' ? 'selected' : '' }}>Batalkan</option>
                            </select>
                        </form>
                        <button onclick="confirmDelete(
                            '{{ route('admin.reservasi.destroy', $r->id_reservasi) }}',
                            'Hapus reservasi {{ $r->user->nama }} di {{ $r->studio->nama_studio }}?'
                        )" class="btn btn-danger btn-sm">Hapus</button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-slate-500 py-8">Belum ada reservasi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $reservasi->links() }}</div>
</div>
@endsection
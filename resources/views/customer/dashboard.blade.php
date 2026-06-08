@extends('layouts.app')
@section('title', 'Dashboard Customer')
@section('page-title', 'Dashboard')
@section('sidebar-nav')
<a href="{{ route('customer.dashboard') }}" class="nav-link {{ request()->routeIs('customer.dashboard')?'active':'' }}">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
    Dashboard
</a>
<a href="{{ route('customer.booking.index') }}" class="nav-link {{ request()->routeIs('customer.booking.*')?'active':'' }}">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    Booking Studio
</a>
<a href="{{ route('customer.jadwal.index') }}" class="nav-link {{ request()->routeIs('customer.jadwal.*')?'active':'' }}">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
    Cek Jadwal
</a>
<a href="{{ route('customer.riwayat.index') }}" class="nav-link {{ request()->routeIs('customer.riwayat.*')?'active':'' }}">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
    Riwayat Saya
</a>
@endsection

@section('content')
<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="card p-5"><p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Total Booking</p><p class="font-display text-3xl font-bold text-white">{{ $totalReservasi }}</p></div>
    <div class="card p-5"><p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Dikonfirmasi</p><p class="font-display text-3xl font-bold text-green-400">{{ $totalConfirmed }}</p></div>
    <div class="card p-5"><p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Menunggu</p><p class="font-display text-3xl font-bold text-yellow-400">{{ $totalPending }}</p></div>
    <div class="card p-5"><p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Total Pengeluaran</p><p class="font-display text-2xl font-bold text-violet-400">Rp {{ number_format($totalPengeluaran,0,',','.') }}</p></div>
</div>

<div class="grid grid-cols-3 gap-4 mb-6">
    @foreach($studios as $studio)
    <div class="card p-5">
        <h3 class="font-display font-bold text-white mb-1">{{ $studio->nama_studio }}</h3>
        <p class="text-slate-400 text-sm mb-3">{{ Str::limit($studio->deskripsi, 60) }}</p>
        <p class="text-violet-400 font-bold mb-3">Rp {{ number_format($studio->harga_per_jam,0,',','.') }}/jam</p>
        <a href="{{ route('customer.booking.index') }}?studio={{ $studio->id_studio }}" class="btn btn-violet btn-sm w-full text-center">Booking Sekarang</a>
    </div>
    @endforeach
</div>

<div class="card">
    <div class="flex items-center justify-between p-5 border-b border-white/5">
        <h3 class="font-display font-bold text-white">Reservasi Terbaru</h3>
        <a href="{{ route('customer.riwayat.index') }}" class="text-violet-400 text-sm">Lihat semua →</a>
    </div>
    <table>
        <thead><tr><th>Studio</th><th>Tanggal</th><th>Jam</th><th>Total</th><th>Status</th><th>Pembayaran</th></tr></thead>
        <tbody>
            @forelse($recentReservasi as $r)
            <tr>
                <td class="text-white font-medium">{{ $r->studio->nama_studio }}</td>
                <td class="text-slate-300">{{ $r->tanggal->format('d M Y') }}</td>
                <td class="text-slate-300">{{ substr($r->jam_mulai,0,5) }} - {{ substr($r->jam_selesai,0,5) }}</td>
                <td class="text-slate-300">Rp {{ number_format($r->total_harga,0,',','.') }}</td>
                <td><span class="badge {{ $r->status_badge }}">{{ $r->status_label }}</span></td>
                <td>
                    @if($r->pembayaran && $r->pembayaran->status_bayar === 'belum_bayar' && $r->status !== 'cancelled')
                    <a href="{{ route('customer.pembayaran.show', $r) }}" class="btn btn-violet btn-sm">Bayar</a>
                    @else
                    <span class="badge {{ $r->pembayaran?->status_badge ?? 'badge-belum' }}">{{ $r->pembayaran?->status_label ?? 'Belum Bayar' }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-slate-500 py-8">Belum ada reservasi</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
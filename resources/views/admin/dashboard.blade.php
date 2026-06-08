@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->nama)

@section('sidebar-nav')
<a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
    Dashboard
</a>
<a href="{{ route('admin.studio.index') }}" class="nav-link {{ request()->routeIs('admin.studio.*') ? 'active' : '' }}">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
    Kelola Studio
</a>
<a href="{{ route('admin.user.index') }}" class="nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
    Kelola User
</a>
<a href="{{ route('admin.reservasi.index') }}" class="nav-link {{ request()->routeIs('admin.reservasi.*') ? 'active' : '' }}">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
    Reservasi
</a>
<a href="{{ route('admin.pengaturan.index') }}" class="nav-link {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    Pengaturan Jam
</a>
@endsection

@section('topbar-actions')
<a href="{{ route('admin.report.pdf') }}" class="btn btn-ghost btn-sm">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
    Export PDF
</a>
<a href="{{ route('admin.report.excel') }}" class="btn btn-violet btn-sm">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
    Export Excel
</a>
@endsection

@section('content')
{{-- Stat Cards --}}
<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="card p-5">
        <p class="text-xs text-slate-500 font-medium uppercase tracking-wider mb-1">Total Studio</p>
        <p class="font-display text-3xl font-bold text-white">{{ $totalStudio }}</p>
        <p class="text-xs text-slate-500 mt-1">Studio terdaftar</p>
    </div>
    <div class="card p-5">
        <p class="text-xs text-slate-500 font-medium uppercase tracking-wider mb-1">Total Reservasi</p>
        <p class="font-display text-3xl font-bold text-white">{{ $totalReservasi }}</p>
        <p class="text-xs text-slate-500 mt-1">Semua reservasi</p>
    </div>
    <div class="card p-5">
        <p class="text-xs text-slate-500 font-medium uppercase tracking-wider mb-1">Menunggu</p>
        <p class="font-display text-3xl font-bold text-yellow-400">{{ $totalPending }}</p>
        <p class="text-xs text-slate-500 mt-1">Perlu konfirmasi</p>
    </div>
    <div class="card p-5">
        <p class="text-xs text-slate-500 font-medium uppercase tracking-wider mb-1">Total Pendapatan</p>
        <p class="font-display text-2xl font-bold text-green-400">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        <p class="text-xs text-slate-500 mt-1">Pembayaran lunas</p>
    </div>
</div>

{{-- Charts --}}
<div class="grid grid-cols-2 gap-4 mb-6">
    <div class="card p-5">
        <h3 class="font-display font-bold text-white mb-4">Reservasi per Bulan</h3>
        <canvas id="chartReservasi" height="200"></canvas>
    </div>
    <div class="card p-5">
        <h3 class="font-display font-bold text-white mb-4">Pendapatan per Studio</h3>
        <canvas id="chartPendapatan" height="200"></canvas>
    </div>
</div>

{{-- Recent Reservasi --}}
<div class="card">
    <div class="flex items-center justify-between p-5 border-b border-white/5">
        <h3 class="font-display font-bold text-white">Reservasi Terbaru</h3>
        <a href="{{ route('admin.reservasi.index') }}" class="text-violet-400 text-sm hover:text-violet-300">Lihat semua →</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Customer</th>
                <th>Studio</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentReservasi as $r)
            <tr>
                <td>
                    <p class="text-white font-medium">{{ $r->user->nama }}</p>
                    <p class="text-slate-500 text-xs">{{ $r->user->email }}</p>
                </td>
                <td class="text-slate-300">{{ $r->studio->nama_studio }}</td>
                <td class="text-slate-300">{{ $r->tanggal->format('d M Y') }}</td>
                <td class="text-slate-300">{{ substr($r->jam_mulai,0,5) }} - {{ substr($r->jam_selesai,0,5) }}</td>
                <td class="text-slate-300">Rp {{ number_format($r->total_harga, 0, ',', '.') }}</td>
                <td><span class="badge {{ $r->status_badge }}">{{ $r->status_label }}</span></td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-slate-500 py-8">Belum ada reservasi</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
fetch('{{ route("admin.chart.data") }}')
    .then(r => r.json())
    .then(data => {
        // Chart Reservasi
        new Chart(document.getElementById('chartReservasi'), {
            type: 'bar',
            data: {
                labels: data.reservasi.labels,
                datasets: [{
                    label: 'Reservasi',
                    data: data.reservasi.data,
                    backgroundColor: 'rgba(124,58,237,0.7)',
                    borderColor: 'rgba(124,58,237,1)',
                    borderWidth: 1, borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { labels: { color: '#94a3b8' } } },
                scales: {
                    x: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(255,255,255,0.05)' } },
                    y: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(255,255,255,0.05)' }, beginAtZero: true }
                }
            }
        });

        // Chart Pendapatan
        new Chart(document.getElementById('chartPendapatan'), {
            type: 'doughnut',
            data: {
                labels: data.pendapatan.labels,
                datasets: [{
                    data: data.pendapatan.data,
                    backgroundColor: ['rgba(124,58,237,0.8)', 'rgba(16,185,129,0.8)', 'rgba(245,158,11,0.8)', 'rgba(239,68,68,0.8)'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { labels: { color: '#94a3b8' }, position: 'bottom' } }
            }
        });
    });
</script>
@endpush
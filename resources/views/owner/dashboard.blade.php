@extends('layouts.app')
@section('title', 'Dashboard Owner')
@section('page-title', 'Dashboard Owner')
@section('sidebar-nav')
<a href="{{ route('owner.dashboard') }}" class="nav-link {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
    Dashboard
</a>
<a href="{{ route('owner.studio.index') }}" class="nav-link {{ request()->routeIs('owner.studio.*') ? 'active' : '' }}">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
    Studio Saya
</a>
<a href="{{ route('owner.reservasi.index') }}" class="nav-link {{ request()->routeIs('owner.reservasi.*') ? 'active' : '' }}">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
    Reservasi
</a>
@endsection

@section('topbar-actions')
<a href="{{ route('owner.report.pdf') }}"   class="btn btn-ghost btn-sm">Export PDF</a>
<a href="{{ route('owner.report.excel') }}" class="btn btn-violet btn-sm">Export Excel</a>
@endsection

@section('content')
<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="card p-5"><p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Studio Saya</p><p class="font-display text-3xl font-bold text-white">{{ $totalStudio }}</p></div>
    <div class="card p-5"><p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Total Reservasi</p><p class="font-display text-3xl font-bold text-white">{{ $totalReservasi }}</p></div>
    <div class="card p-5"><p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Menunggu</p><p class="font-display text-3xl font-bold text-yellow-400">{{ $totalPending }}</p></div>
    <div class="card p-5"><p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Pendapatan</p><p class="font-display text-2xl font-bold text-green-400">Rp {{ number_format($totalPendapatan,0,',','.') }}</p></div>
</div>
<div class="grid grid-cols-2 gap-4 mb-6">
    <div class="card p-5"><h3 class="font-display font-bold text-white mb-4">Reservasi per Bulan</h3><canvas id="chartReservasi" height="200"></canvas></div>
    <div class="card p-5"><h3 class="font-display font-bold text-white mb-4">Pendapatan per Studio</h3><canvas id="chartPendapatan" height="200"></canvas></div>
</div>
<div class="card">
    <div class="flex items-center justify-between p-5 border-b border-white/5">
        <h3 class="font-display font-bold text-white">Reservasi Terbaru</h3>
        <a href="{{ route('owner.reservasi.index') }}" class="text-violet-400 text-sm">Lihat semua →</a>
    </div>
    <table>
        <thead><tr><th>Customer</th><th>Studio</th><th>Tanggal</th><th>Total</th><th>Status</th></tr></thead>
        <tbody>
            @forelse($recentReservasi as $r)
            <tr>
                <td><p class="text-white font-medium">{{ $r->user->nama }}</p></td>
                <td class="text-slate-300">{{ $r->studio->nama_studio }}</td>
                <td class="text-slate-300">{{ $r->tanggal->format('d M Y') }}</td>
                <td class="text-slate-300">Rp {{ number_format($r->total_harga,0,',','.') }}</td>
                <td><span class="badge {{ $r->status_badge }}">{{ $r->status_label }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-slate-500 py-8">Belum ada reservasi</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
@push('scripts')
<script>
fetch('{{ route("owner.chart.data") }}').then(r=>r.json()).then(data=>{
    new Chart(document.getElementById('chartReservasi'),{type:'bar',data:{labels:data.reservasi.labels,datasets:[{label:'Reservasi',data:data.reservasi.data,backgroundColor:'rgba(124,58,237,0.7)',borderRadius:6}]},options:{responsive:true,plugins:{legend:{labels:{color:'#94a3b8'}}},scales:{x:{ticks:{color:'#94a3b8'},grid:{color:'rgba(255,255,255,0.05)'}},y:{ticks:{color:'#94a3b8'},grid:{color:'rgba(255,255,255,0.05)'},beginAtZero:true}}}});
    new Chart(document.getElementById('chartPendapatan'),{type:'doughnut',data:{labels:data.pendapatan.labels,datasets:[{data:data.pendapatan.data,backgroundColor:['rgba(124,58,237,0.8)','rgba(16,185,129,0.8)','rgba(245,158,11,0.8)'],borderWidth:0}]},options:{responsive:true,plugins:{legend:{labels:{color:'#94a3b8'},position:'bottom'}}}});
});
</script>
@endpush
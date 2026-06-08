@extends('layouts.app')
@section('title', 'Jadwal Studio')
@section('page-title', 'Jadwal Studio')
@section('page-subtitle', 'Cek ketersediaan studio per jam')

@section('sidebar-nav')
<a href="{{ route('customer.dashboard') }}" class="nav-link">Dashboard</a>
<a href="{{ route('customer.booking.index') }}" class="nav-link">Booking Studio</a>
<a href="{{ route('customer.jadwal.index') }}" class="nav-link active">Cek Jadwal</a>
<a href="{{ route('customer.riwayat.index') }}" class="nav-link">Riwayat Saya</a>
@endsection

@section('content')

{{-- Filter Studio --}}
<div class="card p-5 mb-4">
    <form method="GET" class="flex flex-wrap items-end gap-4">
        <div class="flex-1 min-w-48">
            <label class="block text-xs font-medium text-slate-400 mb-1">Pilih Studio</label>
            <select name="studio" class="form-input">
                <option value="">-- Pilih Studio --</option>
                @foreach($studios as $s)
                <option value="{{ $s->id_studio }}" {{ $selectedStudio == $s->id_studio ? 'selected' : '' }}>
                    {{ $s->nama_studio }}
                </option>
                @endforeach
            </select>
        </div>
        <input type="hidden" name="week" value="{{ $weekOffset }}">
        <button type="submit" class="btn btn-violet">Tampilkan</button>
    </form>
</div>

@if($selectedStudio > 0)

{{-- Navigasi Minggu --}}
<div class="card p-4 mb-4 flex items-center justify-between">
    <a href="{{ route('customer.jadwal.index') }}?studio={{ $selectedStudio }}&week={{ $weekOffset - 1 }}" class="btn btn-ghost btn-sm">← Minggu Lalu</a>
    <div class="text-center">
        <p class="font-display font-bold text-white">{{ $days[0]->format('d M') }} – {{ $days[6]->format('d M Y') }}</p>
        <span class="text-xs {{ $weekOffset == 0 ? 'text-violet-400' : 'text-slate-500' }}">
            @if($weekOffset == 0) Minggu Ini
            @elseif($weekOffset > 0) {{ $weekOffset }} minggu ke depan
            @else {{ abs($weekOffset) }} minggu lalu
            @endif
        </span>
    </div>
    <a href="{{ route('customer.jadwal.index') }}?studio={{ $selectedStudio }}&week={{ $weekOffset + 1 }}" class="btn btn-ghost btn-sm">Minggu Depan →</a>
</div>

{{-- Legenda --}}
<div class="flex items-center gap-4 mb-4 flex-wrap text-xs">
    <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded" style="background:rgba(34,197,94,.3);border:1px solid rgba(34,197,94,.5)"></div><span class="text-slate-400">✅ Tersedia (klik untuk booking)</span></div>
    <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded" style="background:rgba(239,68,68,.2);border:1px solid rgba(239,68,68,.4)"></div><span class="text-slate-400">❌ Sudah Dipesan</span></div>
    <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded" style="background:rgba(245,158,11,.2);border:1px solid rgba(245,158,11,.4)"></div><span class="text-slate-400">⏰ Jam Sudah Lewat</span></div>
    <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded" style="background:rgba(100,116,139,.15);border:1px solid rgba(100,116,139,.2)"></div><span class="text-slate-400">— Hari Sudah Lewat</span></div>
</div>

{{-- Info Waktu Sekarang --}}
<div class="mb-4 px-4 py-2.5 rounded-xl text-xs" style="background:rgba(59,130,246,.1);border:1px solid rgba(59,130,246,.2);color:#93c5fd">
    ⏰ Waktu sekarang: <strong>{{ $now->format('d M Y, H:i') }} WIB</strong> — Slot yang sudah lewat tidak bisa dipesan
</div>

{{-- Tabel Kalender --}}
<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table style="border-collapse:collapse;width:100%;min-width:700px">
            <thead>
                <tr>
                    <th style="background:rgba(124,58,237,.85);color:#fff;padding:12px 16px;text-align:left;width:72px;border-right:1px solid rgba(255,255,255,.1);font-size:.78rem;letter-spacing:.05em">JAM</th>
                    @foreach($days as $i => $day)
                    @php
                        $todayStr  = $now->format('Y-m-d');
                        $dayStr    = $day->format('Y-m-d');
                        $isToday   = $dayStr === $todayStr;
                        $isPastDay = $dayStr < $todayStr;
                        $bgHeader  = $isToday ? 'rgba(124,58,237,1)' : ($isPastDay ? 'rgba(60,40,100,.5)' : 'rgba(124,58,237,.75)');
                    @endphp
                    <th style="background:{{ $bgHeader }};color:{{ $isPastDay ? 'rgba(255,255,255,.4)' : '#fff' }};padding:10px 6px;text-align:center;border-right:1px solid rgba(255,255,255,.08);font-size:.78rem;min-width:100px">
                        <div style="font-weight:600">{{ ['Sen','Sel','Rab','Kam','Jum','Sab','Min'][$i] }}</div>
                        <div style="font-size:.7rem;opacity:.8;font-weight:400">{{ $day->format('d/m') }}</div>
                        @if($isToday)
                        <div style="font-size:.65rem;background:#fff;color:#7c3aed;border-radius:20px;padding:1px 8px;margin-top:3px;font-weight:700;display:inline-block">Hari ini</div>
                        @endif
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @for($h = $jamBuka; $h < $jamTutup; $h++)
                <tr style="border-bottom:1px solid rgba(255,255,255,.04)">
                    {{-- Label Jam --}}
                    <td style="padding:9px 14px;font-family:monospace;font-size:.78rem;font-weight:600;color:#64748b;border-right:1px solid rgba(255,255,255,.05);background:rgba(255,255,255,.02);white-space:nowrap">
                        {{ sprintf('%02d:00', $h) }}
                    </td>

                    @foreach($days as $day)
                    @php
                        $dayStr     = $day->format('Y-m-d');
                        $todayStr   = $now->format('Y-m-d');
                        $isToday    = $dayStr === $todayStr;
                        $isPastDay  = $dayStr < $todayStr;
                        // Jam dianggap lewat jika: jam slot <= jam sekarang (karena slot 16:00 artinya 16:00-17:00,
                        // dan jika sekarang jam 16:39 maka slot 16:00 sudah berjalan = tidak bisa booking)
                        $isPastHour = $isToday && $h <= $now->hour;                        
                        $isBooked   = isset($reservasiMinggu[$dayStr][$h]);
                        $jamMulai   = sprintf('%02d:00', $h);
                        $jamSel     = sprintf('%02d:00', $h + 1);
                        $todayRing  = $isToday ? ';box-shadow:inset 0 0 0 1px rgba(124,58,237,.35)' : '';
                    @endphp

                    @if($isBooked)
                        {{-- MERAH: sudah dipesan --}}
                        <td style="padding:8px 6px;text-align:center;background:rgba(239,68,68,.13);border:1px solid rgba(239,68,68,.25){{ $todayRing }}">
                            <span style="color:#f87171;font-size:.72rem;font-weight:700">❌ Booked</span>
                        </td>
                    @elseif($isPastDay)
                        {{-- ABU-ABU GELAP: hari kemarin/sebelumnya --}}
                        <td style="padding:8px 6px;text-align:center;background:rgba(100,116,139,.07);border:1px solid rgba(100,116,139,.12)">
                            <span style="color:rgba(100,116,139,.35);font-size:.72rem">—</span>
                        </td>
                    @elseif($isPastHour)
                        {{-- ORANGE: jam sudah lewat hari ini --}}
                        <td style="padding:8px 6px;text-align:center;background:rgba(245,158,11,.1);border:1px solid rgba(245,158,11,.25){{ $todayRing }}">
                            <span style="color:#fbbf24;font-size:.72rem;font-weight:600">⏰ Lewat</span>
                        </td>
                    @else
                        {{-- HIJAU: tersedia, bisa diklik --}}
                        <td style="padding:8px 6px;text-align:center;background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.22){{ $todayRing }};cursor:pointer" onmouseover="this.style.background='rgba(34,197,94,.18)'" onmouseout="this.style.background='rgba(34,197,94,.08)'">
                            <a href="{{ route('customer.booking.index') }}?studio={{ $selectedStudio }}&tanggal={{ $dayStr }}&jam_mulai={{ $jamMulai }}&jam_selesai={{ $jamSel }}"
                               style="color:#4ade80;font-size:.72rem;font-weight:600;text-decoration:none;display:block">
                                ✅ Tersedia
                            </a>
                        </td>
                    @endif
                    @endforeach
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
    <div class="flex items-center justify-between px-5 py-3" style="border-top:1px solid rgba(255,255,255,.05);background:rgba(255,255,255,.02)">
        <p class="text-xs text-slate-500">Jam operasional: {{ sprintf('%02d:00', $jamBuka) }} – {{ sprintf('%02d:00', $jamTutup) }} WIB</p>
        <a href="{{ route('customer.booking.index') }}" class="btn btn-violet btn-sm">+ Booking Sekarang</a>
    </div>
</div>

@else
{{-- Belum pilih studio --}}
<div class="card p-12 text-center">
    <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4" style="background:rgba(124,58,237,.15)">
        <svg class="w-8 h-8 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
    </div>
    <h3 class="font-display font-bold text-white mb-2">Pilih Studio Terlebih Dahulu</h3>
    <p class="text-slate-400 text-sm">Pilih studio di atas untuk melihat jadwal ketersediaan per jam</p>
</div>
@endif
@endsection
@extends('layouts.app')
@section('title', 'Pembayaran')
@section('page-title', 'Konfirmasi Pembayaran')
@section('sidebar-nav')
<a href="{{ route('customer.dashboard') }}" class="nav-link">Dashboard</a>
<a href="{{ route('customer.booking.index') }}" class="nav-link">Booking Studio</a>
<a href="{{ route('customer.jadwal.index') }}" class="nav-link">Cek Jadwal</a>
<a href="{{ route('customer.riwayat.index') }}" class="nav-link">Riwayat Saya</a>
@endsection

@section('content')
<div class="max-w-lg">
    <div class="card p-6 mb-4">
        <h3 class="font-display font-bold text-white mb-4">Detail Reservasi</h3>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between"><span class="text-slate-400">Studio</span><span class="text-white font-medium">{{ $reservasi->studio->nama_studio }}</span></div>
            <div class="flex justify-between"><span class="text-slate-400">Tanggal</span><span class="text-white">{{ $reservasi->tanggal->format('d M Y') }}</span></div>
            <div class="flex justify-between"><span class="text-slate-400">Jam</span><span class="text-white">{{ substr($reservasi->jam_mulai,0,5) }} - {{ substr($reservasi->jam_selesai,0,5) }}</span></div>
            <div class="flex justify-between"><span class="text-slate-400">Durasi</span><span class="text-white">{{ $reservasi->durasi_jam }} jam</span></div>
            <div class="border-t border-white/5 pt-2 mt-2 flex justify-between">
                <span class="text-slate-300 font-medium">Total Pembayaran</span>
                <span class="text-violet-400 font-bold text-lg">Rp {{ number_format($reservasi->total_harga,0,',','.') }}</span>
            </div>
        </div>
    </div>

    <div class="card p-6">
        <h3 class="font-display font-bold text-white mb-4">Metode Pembayaran</h3>
        <form action="{{ route('customer.pembayaran.store', $reservasi) }}" method="POST">
        @csrf
        <div class="space-y-3 mb-6">
            @foreach(['transfer' => 'Transfer Bank', 'ewallet' => 'E-Wallet', 'tunai' => 'Tunai'] as $val => $label)
            <label class="flex items-center gap-3 p-4 rounded-xl border border-white/10 cursor-pointer hover:border-violet-500/50 has-[:checked]:border-violet-500 has-[:checked]:bg-violet-500/10 transition-all">
                <input type="radio" name="metode_bayar" value="{{ $val }}" class="accent-violet-500" {{ old('metode_bayar') === $val ? 'checked' : '' }}>
                <span class="text-white font-medium">{{ $label }}</span>
            </label>
            @endforeach
        </div>
        @error('metode_bayar')<p class="mb-4 text-red-400 text-xs">{{ $message }}</p>@enderror
        <div class="flex gap-3">
            <button type="submit" class="btn btn-violet flex-1">Konfirmasi Pembayaran</button>
            <a href="{{ route('customer.riwayat.index') }}" class="btn btn-ghost">Kembali</a>
        </div>
        </form>
    </div>
</div>
@endsection
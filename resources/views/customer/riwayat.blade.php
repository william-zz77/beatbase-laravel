@extends('layouts.app')
@section('title', 'Riwayat Reservasi')
@section('page-title', 'Riwayat Reservasi Saya')
@section('sidebar-nav')
<a href="{{ route('customer.dashboard') }}" class="nav-link">Dashboard</a>
<a href="{{ route('customer.booking.index') }}" class="nav-link">Booking Studio</a>
<a href="{{ route('customer.jadwal.index') }}" class="nav-link">Cek Jadwal</a>
<a href="{{ route('customer.riwayat.index') }}" class="nav-link active">Riwayat Saya</a>
@endsection

@section('content')
<div class="card">
    <table>
        <thead>
            <tr>
                <th>Studio</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Durasi</th>
                <th>Total</th>
                <th>Status</th>
                <th>Pembayaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservasi as $r)
            <tr>
                <td class="text-white font-medium">{{ $r->studio->nama_studio }}</td>
                <td class="text-slate-300">{{ $r->tanggal->format('d M Y') }}</td>
                <td class="text-slate-300">{{ substr($r->jam_mulai,0,5) }} - {{ substr($r->jam_selesai,0,5) }}</td>
                <td class="text-slate-300">{{ $r->durasi_jam }} jam</td>
                <td class="text-slate-300">Rp {{ number_format($r->total_harga,0,',','.') }}</td>
                <td>
                    <span class="badge {{ $r->status_badge }}">{{ $r->status_label }}</span>
                </td>
                <td>
                    @if($r->pembayaran)
                        <span class="badge {{ $r->pembayaran->status_badge }}">
                            {{ $r->pembayaran->status_label }}
                        </span>
                    @else
                        <span class="badge badge-belum">Belum Bayar</span>
                    @endif
                </td>
                <td>
                    <div class="flex gap-2 items-center">

                        {{-- Tombol Bayar: hanya jika status_bayar belum_bayar dan reservasi tidak cancelled --}}
                        @if($r->status !== 'cancelled'
                            && $r->pembayaran
                            && $r->pembayaran->status_bayar === 'belum_bayar')
                            <a href="{{ route('customer.pembayaran.show', $r->id_reservasi) }}"
                                class="btn btn-violet btn-sm">Bayar</a>
                        @endif

                        {{-- Tombol Batal: hanya jika masih pending --}}
                        @if($r->status === 'pending')
                            <form method="POST" action="{{ route('customer.riwayat.batal', $r->id_reservasi) }}">
                                @csrf @method('PATCH')
                                <button type="submit"
                                    onclick="return confirm('Batalkan reservasi ini?')"
                                    class="btn btn-danger btn-sm">Batal</button>
                            </form>
                        @endif

                        {{-- Label selesai jika sudah confirmed & lunas --}}
                        @if($r->status === 'confirmed'
                            && $r->pembayaran
                            && $r->pembayaran->status_bayar === 'lunas')
                            <span class="text-green-400 text-xs font-medium">✓ Selesai</span>
                        @endif

                        {{-- Tidak ada aksi jika cancelled --}}
                        @if($r->status === 'cancelled')
                            <span class="text-slate-500 text-xs">—</span>
                        @endif

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-slate-500 py-8">
                    Belum ada riwayat reservasi
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $reservasi->links() }}</div>
</div>
@endsection
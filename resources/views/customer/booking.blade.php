@extends('layouts.app')
@section('title', 'Booking Studio')
@section('page-title', 'Booking Studio')
@section('sidebar-nav')
<a href="{{ route('customer.dashboard') }}" class="nav-link">Dashboard</a>
<a href="{{ route('customer.booking.index') }}" class="nav-link active">Booking Studio</a>
<a href="{{ route('customer.jadwal.index') }}" class="nav-link">Cek Jadwal</a>
<a href="{{ route('customer.riwayat.index') }}" class="nav-link">Riwayat Saya</a>
@endsection

@section('content')
<div class="max-w-2xl"><div class="card p-6">
<form action="{{ route('customer.booking.store') }}" method="POST">
@csrf

<div class="mb-4">
    <label class="block text-sm font-medium text-slate-300 mb-1.5">Pilih Studio</label>
    <select name="id_studio" id="id_studio" class="form-input" onchange="updateInfo()">
        <option value="">-- Pilih Studio --</option>
        @foreach($studios as $studio)
        <option value="{{ $studio->id_studio }}"
            data-harga="{{ $studio->harga_per_jam }}"
            {{ old('id_studio', request('studio')) == $studio->id_studio ? 'selected' : '' }}>
            {{ $studio->nama_studio }} — Rp {{ number_format($studio->harga_per_jam,0,',','.') }}/jam
        </option>
        @endforeach
    </select>
    @error('id_studio')<p class="mt-1 text-red-400 text-xs">{{ $message }}</p>@enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-slate-300 mb-1.5">Tanggal</label>
    <input type="date" name="tanggal" value="{{ old('tanggal') }}"
        min="{{ date('Y-m-d') }}" class="form-input">
    @error('tanggal')<p class="mt-1 text-red-400 text-xs">{{ $message }}</p>@enderror
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <label class="block text-sm font-medium text-slate-300 mb-1.5">Jam Mulai</label>
        <select name="jam_mulai" id="jam_mulai" class="form-input" onchange="hitungHarga()">
            <option value="">-- Pilih Jam --</option>
            @php
                $jamBukaInt  = (int)substr($jam->jam_buka, 0, 2);
                $jamTutupInt = (int)substr($jam->jam_tutup, 0, 2);
            @endphp
            @for($h = $jamBukaInt; $h < $jamTutupInt; $h++)
                <option value="{{ sprintf('%02d:00', $h) }}"
                    {{ old('jam_mulai') == sprintf('%02d:00', $h) ? 'selected' : '' }}>
                    {{ sprintf('%02d:00', $h) }}
                </option>
            @endfor
        </select>
        @error('jam_mulai')<p class="mt-1 text-red-400 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-300 mb-1.5">Jam Selesai</label>
        <select name="jam_selesai" id="jam_selesai" class="form-input" onchange="hitungHarga()">
            <option value="">-- Pilih Jam --</option>
            @for($h = $jamBukaInt + 1; $h <= $jamTutupInt; $h++)
                <option value="{{ sprintf('%02d:00', $h) }}"
                    {{ old('jam_selesai') == sprintf('%02d:00', $h) ? 'selected' : '' }}>
                    {{ sprintf('%02d:00', $h) }}
                </option>
            @endfor
        </select>
        @error('jam_selesai')<p class="mt-1 text-red-400 text-xs">{{ $message }}</p>@enderror
    </div>
</div>

{{-- Kalkulasi Harga --}}
<div id="harga-preview" class="hidden mb-4 p-4 rounded-xl" style="background:rgba(124,58,237,.1);border:1px solid rgba(124,58,237,.2)">
    <div class="flex justify-between text-sm text-slate-300 mb-1">
        <span>Durasi</span><span id="prev-durasi">-</span>
    </div>
    <div class="flex justify-between text-sm text-slate-300 mb-1">
        <span>Harga/Jam</span><span id="prev-harga">-</span>
    </div>
    <div class="flex justify-between font-bold text-white">
        <span>Total</span><span id="prev-total" class="text-violet-400">-</span>
    </div>
</div>

<div class="mb-6">
    <label class="block text-sm font-medium text-slate-300 mb-1.5">Catatan <span class="text-slate-500">(opsional)</span></label>
    <textarea name="catatan" rows="2" class="form-input" placeholder="Keperluan khusus...">{{ old('catatan') }}</textarea>
</div>

<p class="text-xs text-slate-500 mb-4">Jam operasional: {{ substr($jam->jam_buka,0,5) }} - {{ substr($jam->jam_tutup,0,5) }}</p>

<div class="flex gap-3">
    <button type="submit" class="btn btn-violet">Booking Sekarang</button>
    <a href="{{ route('customer.dashboard') }}" class="btn btn-ghost">Batal</a>
</div>
</form>
</div></div>
@endsection

@push('scripts')
<script>
function hitungHarga() {
    const studioEl = document.getElementById('id_studio');
    const mulai    = document.getElementById('jam_mulai').value;
    const selesai  = document.getElementById('jam_selesai').value;

    if (!studioEl.value || !mulai || !selesai) return;

    fetch('{{ route("customer.booking.hitung") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            id_studio:   studioEl.value,
            jam_mulai:   mulai,
            jam_selesai: selesai,
        }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.error) {
            document.getElementById('harga-preview').classList.add('hidden');
            return;
        }
        document.getElementById('prev-durasi').textContent = data.durasi + ' jam';
        document.getElementById('prev-harga').textContent  = 'Rp ' + Number(data.harga_per_jam).toLocaleString('id');
        document.getElementById('prev-total').textContent  = data.total_format;
        document.getElementById('harga-preview').classList.remove('hidden');
    })
    .catch(() => {
        document.getElementById('harga-preview').classList.add('hidden');
    });
}
</script>
@endpush
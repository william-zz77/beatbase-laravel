<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Reservasi</title>
<style>
    body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
    h1 { font-size: 18px; color: #7c3aed; margin-bottom: 4px; }
    p.sub { color: #666; font-size: 11px; margin-bottom: 16px; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #7c3aed; color: #fff; padding: 8px 10px; text-align: left; font-size: 11px; }
    td { padding: 7px 10px; border-bottom: 1px solid #eee; font-size: 11px; }
    tr:nth-child(even) td { background: #f9f7ff; }
    .total-box { margin-top: 16px; text-align: right; }
    .total-box span { font-size: 14px; font-weight: bold; color: #7c3aed; }
</style>
</head>
<body>
<h1>Laporan Reservasi — BeatBase</h1>
<p class="sub">Dicetak pada: {{ now()->format('d M Y, H:i') }}</p>
<table>
    <thead>
        <tr><th>No</th><th>Customer</th><th>Studio</th><th>Tanggal</th><th>Jam</th><th>Total</th><th>Status</th><th>Pembayaran</th></tr>
    </thead>
    <tbody>
        @foreach($reservasi as $i => $r)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $r->user->nama ?? '-' }}</td>
            <td>{{ $r->studio->nama_studio ?? '-' }}</td>
            <td>{{ $r->tanggal->format('d/m/Y') }}</td>
            <td>{{ substr($r->jam_mulai,0,5) }} - {{ substr($r->jam_selesai,0,5) }}</td>
            <td>Rp {{ number_format($r->total_harga,0,',','.') }}</td>
            <td>{{ $r->status_label }}</td>
            <td>{{ $r->pembayaran?->status_label ?? 'Belum Bayar' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="total-box">
    Total Pendapatan: <span>Rp {{ number_format($totalPendapatan,0,',','.') }}</span>
</div>
</body>
</html>
@extends('layouts.app')
@section('title','Admin Dashboard')
@section('body')
<body class="bg-gray-100 min-h-screen">
<nav class="bg-purple-700 text-white px-6 py-4 flex items-center justify-between fixed top-0 left-0 right-0 z-50 shadow-lg">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
        </div>
        <span class="text-xl font-bold">Beatbase</span>
        <span class="text-xs bg-white bg-opacity-20 px-2 py-0.5 rounded-full">Admin</span>
    </div>
    <div class="flex items-center gap-4">
        <div class="text-right hidden sm:block">
            <p class="text-sm font-semibold">{{ Auth::user()->nama }}</p>
            <p class="text-xs text-purple-200">{{ Auth::user()->email }}</p>
        </div>
        <div class="w-9 h-9 bg-white bg-opacity-20 rounded-full flex items-center justify-center font-bold">
            {{ strtoupper(substr(Auth::user()->nama,0,1)) }}
        </div>
        <a href="/logout" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-sm px-4 py-2 rounded-lg transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            Logout
        </a>
    </div>
</nav>
<div class="h-16"></div>
<div class="flex">
    @include('layouts.sidebar_admin')
    <main class="flex-1 p-6 ml-64">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
            <p class="text-gray-500">Selamat datang, {{ Auth::user()->nama }}! 👋</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div><p class="text-sm text-gray-500">Total Studio</p><p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalStudio }}</p></div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
                    </div>
                </div>
                <a href="/admin/studio" class="text-xs text-purple-600 hover:underline mt-3 block">Kelola Studio →</a>
            </div>
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div><p class="text-sm text-gray-500">Total Reservasi</p><p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalReservasi }}</p></div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                </div>
                <a href="/admin/reservasi" class="text-xs text-blue-600 hover:underline mt-3 block">Lihat Semua →</a>
            </div>
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div><p class="text-sm text-gray-500">Menunggu Konfirmasi</p><p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalPending }}</p></div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <p class="text-xs text-yellow-600 mt-3">Perlu tindakan segera</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div><p class="text-sm text-gray-500">Total Customer</p><p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalCustomer }}</p></div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                </div>
            </div>
        </div>
        @if($jam)
        <div class="bg-white rounded-xl shadow p-5 mb-6 flex items-center gap-4">
            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-700">Jam Operasional Studio</p>
                <p class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($jam->jam_buka)->format('H:i') }} – {{ \Carbon\Carbon::parse($jam->jam_tutup)->format('H:i') }} WIB</p>
            </div>
            <a href="/admin/pengaturan-jam" class="text-sm bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">Ubah Jam</a>
        </div>
        @endif
        <div class="bg-white rounded-xl shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800">Reservasi Terbaru</h2>
                <a href="/admin/reservasi" class="text-sm text-purple-600 hover:underline">Lihat semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3 text-left">Customer</th>
                            <th class="px-6 py-3 text-left">Studio</th>
                            <th class="px-6 py-3 text-left">Tanggal</th>
                            <th class="px-6 py-3 text-left">Jam</th>
                            <th class="px-6 py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentReservasi as $r)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $r->user->nama }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $r->studio->nama_studio }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ \Carbon\Carbon::parse($r->tanggal)->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ substr($r->jam_mulai,0,5) }} – {{ substr($r->jam_selesai,0,5) }}</td>
                            <td class="px-6 py-4">
                                @php $sc=['pending'=>'bg-yellow-100 text-yellow-700','confirmed'=>'bg-green-100 text-green-700','cancelled'=>'bg-red-100 text-red-700'] @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $sc[$r->status] ?? 'bg-gray-100 text-gray-600' }}">{{ ucfirst($r->status) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada reservasi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
</body>
@endsection
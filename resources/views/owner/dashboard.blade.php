@extends('layouts.app')
@section('title','Owner Dashboard')
@section('body')
<body class="bg-gray-100 min-h-screen">
<nav class="bg-indigo-700 text-white px-6 py-4 flex items-center justify-between fixed top-0 left-0 right-0 z-50 shadow-lg">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
        </div>
        <span class="text-xl font-bold">Beatbase</span>
        <span class="text-xs bg-white bg-opacity-20 px-2 py-0.5 rounded-full">Owner</span>
    </div>
    <div class="flex items-center gap-4">
        <div class="text-right hidden sm:block">
            <p class="text-sm font-semibold">{{ Auth::user()->nama }}</p>
            <p class="text-xs text-indigo-200">{{ Auth::user()->email }}</p>
        </div>
        <div class="w-9 h-9 bg-white bg-opacity-20 rounded-full flex items-center justify-center font-bold">{{ strtoupper(substr(Auth::user()->nama,0,1)) }}</div>
        <a href="/logout" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-sm px-4 py-2 rounded-lg transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            Logout
        </a>
    </div>
</nav>
<div class="h-16"></div>
<div class="flex">
    <aside class="w-64 bg-white shadow-md fixed left-0 top-16 bottom-0 overflow-y-auto z-40">
        <nav class="p-4 space-y-1">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-3">Menu</p>
            <a href="/owner/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->is('owner/dashboard') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="/owner/reservasi" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->is('owner/reservasi*') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Data Reservasi
            </a>
            <div class="border-t border-gray-200 my-3"></div>
            <a href="/logout" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-red-500 hover:bg-red-50 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </a>
        </nav>
    </aside>
    <main class="flex-1 p-6 ml-64">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Owner</h1>
            <p class="text-gray-500">Selamat datang, {{ Auth::user()->nama }}! 👋</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-indigo-500">
                <p class="text-sm text-gray-500">Total Studio</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalStudio }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-500">
                <p class="text-sm text-gray-500">Total Reservasi</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalReservasi }}</p>
                <a href="/owner/reservasi" class="text-xs text-blue-600 hover:underline mt-3 block">Lihat Semua →</a>
            </div>
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-500">
                <p class="text-sm text-gray-500">Confirmed</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalConfirmed }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-yellow-500">
                <p class="text-sm text-gray-500">Pending</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalPending }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between">
                <h2 class="text-lg font-semibold text-gray-800">Reservasi Terbaru</h2>
                <a href="/owner/reservasi" class="text-sm text-indigo-600 hover:underline">Lihat semua →</a>
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
                        @php $sc=['pending'=>'bg-yellow-100 text-yellow-700','confirmed'=>'bg-green-100 text-green-700','cancelled'=>'bg-red-100 text-red-700'] @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $r->user->nama }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $r->studio->nama_studio }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ \Carbon\Carbon::parse($r->tanggal)->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ substr($r->jam_mulai,0,5) }} – {{ substr($r->jam_selesai,0,5) }}</td>
                            <td class="px-6 py-4"><span class="px-2 py-1 rounded-full text-xs font-semibold {{ $sc[$r->status] ?? '' }}">{{ ucfirst($r->status) }}</span></td>
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
@extends('layouts.app')
@section('title','Setting Jam')
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
            <h1 class="text-2xl font-bold text-gray-800">Setting Jam Operasional</h1>
            <p class="text-gray-500">Atur jam buka dan tutup studio</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Atur Jam Operasional</h2>
                        <p class="text-sm text-gray-500">Perubahan berlaku untuk semua studio</p>
                    </div>
                </div>
                <form action="{{ route('admin.pengaturan-jam.update') }}" method="POST" class="space-y-5">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Buka <span class="text-red-500">*</span></label>
                        <input type="time" name="jam_buka" required value="{{ $pengaturan ? substr($pengaturan->jam_buka,0,5) : '09:00' }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 text-lg font-mono">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Tutup <span class="text-red-500">*</span></label>
                        <input type="time" name="jam_tutup" required value="{{ $pengaturan ? substr($pengaturan->jam_tutup,0,5) : '22:00' }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 text-lg font-mono">
                    </div>
                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 rounded-lg transition">Simpan Pengaturan Jam</button>
                </form>
            </div>

            <div class="space-y-4">
                @if($pengaturan)
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">⏰ Jam Operasional Saat Ini</h3>
                    <div class="flex items-center justify-center gap-6 py-4">
                        <div class="text-center">
                            <p class="text-xs text-gray-500 mb-1">BUKA</p>
                            <p class="text-4xl font-bold text-green-600 font-mono">{{ \Carbon\Carbon::parse($pengaturan->jam_buka)->format('H:i') }}</p>
                        </div>
                        <div class="text-gray-300 text-2xl">→</div>
                        <div class="text-center">
                            <p class="text-xs text-gray-500 mb-1">TUTUP</p>
                            <p class="text-4xl font-bold text-red-500 font-mono">{{ \Carbon\Carbon::parse($pengaturan->jam_tutup)->format('H:i') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="bg-white rounded-xl shadow p-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">⚡ Preset Jam Cepat</h3>
                    <div class="grid grid-cols-2 gap-2">
                        <button onclick="setJam('08:00','22:00')" class="text-xs bg-gray-50 hover:bg-purple-50 hover:text-purple-700 border border-gray-200 hover:border-purple-300 text-gray-600 py-2 px-3 rounded-lg transition text-left">
                            <span class="font-semibold block">Standar</span>08:00 – 22:00
                        </button>
                        <button onclick="setJam('09:00','21:00')" class="text-xs bg-gray-50 hover:bg-purple-50 hover:text-purple-700 border border-gray-200 hover:border-purple-300 text-gray-600 py-2 px-3 rounded-lg transition text-left">
                            <span class="font-semibold block">Normal</span>09:00 – 21:00
                        </button>
                        <button onclick="setJam('10:00','22:00')" class="text-xs bg-gray-50 hover:bg-purple-50 hover:text-purple-700 border border-gray-200 hover:border-purple-300 text-gray-600 py-2 px-3 rounded-lg transition text-left">
                            <span class="font-semibold block">Siang</span>10:00 – 22:00
                        </button>
                        <button onclick="setJam('09:00','23:00')" class="text-xs bg-gray-50 hover:bg-purple-50 hover:text-purple-700 border border-gray-200 hover:border-purple-300 text-gray-600 py-2 px-3 rounded-lg transition text-left">
                            <span class="font-semibold block">Extended</span>09:00 – 23:00
                        </button>
                    </div>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5">
                    <h3 class="text-sm font-semibold text-yellow-800 mb-2">⚠️ Perhatian</h3>
                    <ul class="text-sm text-yellow-700 space-y-1">
                        <li>• Perubahan berlaku untuk <strong>semua studio</strong></li>
                        <li>• Customer tidak bisa booking di luar jam operasional</li>
                        <li>• Reservasi yang sudah ada <strong>tidak terpengaruh</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
</div>
<script>
function setJam(buka, tutup) {
    document.querySelector('input[name="jam_buka"]').value = buka;
    document.querySelector('input[name="jam_tutup"]').value = tutup;
}
</script>
</body>
@endsection
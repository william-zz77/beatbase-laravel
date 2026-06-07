@extends('layouts.app')
@section('title','Kelola Studio')
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
            <h1 class="text-2xl font-bold text-gray-800">Kelola Studio</h1>
            <p class="text-gray-500">Tambah, edit, dan hapus data studio</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">{{ isset($editData) ? '✏️ Edit Studio' : '➕ Tambah Studio' }}</h2>
                    <form action="{{ isset($editData) ? route('admin.studio.update', $editData->id_studio) : route('admin.studio.store') }}" method="POST" class="space-y-4">
                        @csrf
                        @if(isset($editData)) @method('PUT') @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Studio <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_studio" required maxlength="100" placeholder="Contoh: Studio A - Rock Room"
                                value="{{ old('nama_studio', $editData->nama_studio ?? '') }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Harga Per Jam (Rp) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                                <input type="number" name="harga_per_jam" required min="1000" step="1000" placeholder="75000"
                                    value="{{ old('harga_per_jam', $editData->harga_per_jam ?? '') }}"
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm">
                            </div>
                        </div>
                        <div class="flex gap-2 pt-2">
                            <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2.5 rounded-lg transition text-sm">
                                {{ isset($editData) ? 'Simpan Perubahan' : 'Tambah Studio' }}
                            </button>
                            @if(isset($editData))
                            <a href="/admin/studio" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-lg transition text-sm">Batal</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-800">Daftar Studio</h2>
                        <span class="text-sm text-gray-500">Total: {{ $studios->count() }} studio</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                                <tr>
                                    <th class="px-6 py-3 text-left">No</th>
                                    <th class="px-6 py-3 text-left">Nama Studio</th>
                                    <th class="px-6 py-3 text-left">Harga/Jam</th>
                                    <th class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($studios as $i => $s)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-gray-500">{{ $i+1 }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-800">{{ $s->nama_studio }}</td>
                                    <td class="px-6 py-4 text-gray-600">Rp {{ number_format($s->harga_per_jam,0,',','.') }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.studio.edit', $s->id_studio) }}" class="bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-1.5 rounded-lg text-xs font-medium transition">✏️ Edit</a>
                                            <form action="{{ route('admin.studio.destroy', $s->id_studio) }}" method="POST" onsubmit="return confirm('Yakin hapus studio {{ $s->nama_studio }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg text-xs font-medium transition">🗑️ Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="px-6 py-12 text-center text-gray-400">Belum ada data studio</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
@endsection
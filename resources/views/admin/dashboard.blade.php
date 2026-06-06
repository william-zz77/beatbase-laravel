@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gray-100">
    <nav class="bg-blue-700 text-white px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">🎵 BeatBase - Admin</h1>
        <div class="flex items-center gap-4">
            <span>{{ Auth::user()->nama }}</span>
            <form method="POST" action="/logout">
                @csrf
                <button class="bg-red-500 px-3 py-1 rounded hover:bg-red-600">Logout</button>
            </form>
        </div>
    </nav>
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-6">Dashboard Admin</h2>
        <div class="grid grid-cols-3 gap-4">
            <a href="/admin/studio" class="bg-white p-6 rounded-lg shadow hover:shadow-md">
                <h3 class="text-lg font-semibold text-blue-600">🎸 Kelola Studio</h3>
                <p class="text-gray-500 mt-1">Tambah, edit, hapus studio</p>
            </a>
            <a href="/admin/reservasi" class="bg-white p-6 rounded-lg shadow hover:shadow-md">
                <h3 class="text-lg font-semibold text-green-600">📅 Kelola Reservasi</h3>
                <p class="text-gray-500 mt-1">Lihat semua reservasi</p>
            </a>
            <a href="/admin/pengaturan-jam" class="bg-white p-6 rounded-lg shadow hover:shadow-md">
                <h3 class="text-lg font-semibold text-purple-600">⏰ Pengaturan Jam</h3>
                <p class="text-gray-500 mt-1">Atur jam operasional</p>
            </a>
        </div>
    </div>
</div>
@endsection
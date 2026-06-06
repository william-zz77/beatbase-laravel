@extends('layouts.app')
@section('title', 'Customer Dashboard')

@section('content')
<div class="min-h-screen bg-gray-100">
    <nav class="bg-purple-700 text-white px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">🎵 BeatBase</h1>
        <div class="flex items-center gap-4">
            <span>{{ Auth::user()->nama }}</span>
            <form method="POST" action="/logout">
                @csrf
                <button class="bg-red-500 px-3 py-1 rounded hover:bg-red-600">Logout</button>
            </form>
        </div>
    </nav>
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-6">Dashboard Customer</h2>
        <div class="grid grid-cols-2 gap-4">
            <a href="/customer/reservasi/create" class="bg-white p-6 rounded-lg shadow hover:shadow-md">
                <h3 class="text-lg font-semibold text-purple-600">➕ Buat Reservasi</h3>
                <p class="text-gray-500 mt-1">Pesan studio musik</p>
            </a>
            <a href="/customer/reservasi" class="bg-white p-6 rounded-lg shadow hover:shadow-md">
                <h3 class="text-lg font-semibold text-blue-600">📋 Reservasi Saya</h3>
                <p class="text-gray-500 mt-1">Lihat riwayat reservasi</p>
            </a>
        </div>
    </div>
</div>
@endsection
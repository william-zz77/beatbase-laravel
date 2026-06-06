@extends('layouts.app')
@section('title', 'Owner Dashboard')

@section('content')
<div class="min-h-screen bg-gray-100">
    <nav class="bg-green-700 text-white px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">🎵 BeatBase - Owner</h1>
        <div class="flex items-center gap-4">
            <span>{{ Auth::user()->nama }}</span>
            <form method="POST" action="/logout">
                @csrf
                <button class="bg-red-500 px-3 py-1 rounded hover:bg-red-600">Logout</button>
            </form>
        </div>
    </nav>
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-6">Dashboard Owner</h2>
        <div class="grid grid-cols-2 gap-4">
            <a href="/owner/reservasi" class="bg-white p-6 rounded-lg shadow hover:shadow-md">
                <h3 class="text-lg font-semibold text-green-600">📅 Lihat Reservasi</h3>
                <p class="text-gray-500 mt-1">Monitor semua reservasi studio</p>
            </a>
        </div>
    </div>
</div>
@endsection
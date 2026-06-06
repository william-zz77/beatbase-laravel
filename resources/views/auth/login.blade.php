@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">🎵 BeatBase</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 mb-1">Password</label>
                <input type="password" name="password"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
            </div>
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 font-semibold">
                Login
            </button>
        </form>

        <p class="text-center mt-4 text-gray-600">
            Belum punya akun?
            <a href="/register" class="text-blue-600 hover:underline">Daftar</a>
        </p>
    </div>
</div>
@endsection
@extends('layouts.app')
@section('title','Register')
@section('body')
<body class="bg-gradient-to-br from-purple-900 via-purple-800 to-indigo-900 min-h-screen flex items-center justify-center py-8">
<div class="w-full max-w-md px-4">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-500 rounded-full mb-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-white">Beatbase</h1>
        <p class="text-purple-300 mt-1">Daftar Akun Baru</p>
    </div>
    <div class="bg-white rounded-2xl shadow-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Buat Akun</h2>
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="/register" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" required minlength="3" placeholder="Nama lengkap Anda"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh@email.com"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="password" name="password" id="password" required minlength="6" placeholder="Minimal 6 karakter"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition pr-12">
                    <button type="button" onclick="togglePass('password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="confirm_password" required placeholder="Ulangi password" oninput="checkConfirm()"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition pr-12">
                    <button type="button" onclick="togglePass('confirm_password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                </div>
                <p id="confirm-msg" class="text-xs mt-1"></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Daftar Sebagai <span class="text-red-500">*</span></label>
                <select name="role" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 bg-white">
                    <option value="">-- Pilih Role --</option>
                    <option value="customer" {{ old('role')=='customer'?'selected':'' }}>Customer (Booking Studio)</option>
                    <option value="owner" {{ old('role')=='owner'?'selected':'' }}>Owner (Monitor Reservasi)</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 rounded-lg transition mt-2">Daftar Sekarang</button>
        </form>
        <p class="text-center text-gray-600 mt-6">Sudah punya akun? <a href="/login" class="text-purple-600 font-semibold hover:underline">Masuk di sini</a></p>
    </div>
</div>
<script>
function togglePass(id) { const i=document.getElementById(id); i.type=i.type==='password'?'text':'password'; }
function checkConfirm() {
    const p=document.getElementById('password').value, c=document.getElementById('confirm_password').value, m=document.getElementById('confirm-msg');
    if(!c.length){m.textContent='';return;}
    m.textContent = p===c ? '✓ Password cocok' : '✗ Password tidak cocok';
    m.className = 'text-xs mt-1 ' + (p===c ? 'text-green-600' : 'text-red-500');
}
</script>
</body>
@endsection
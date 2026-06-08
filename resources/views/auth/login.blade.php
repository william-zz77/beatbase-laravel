@extends('layouts.auth')
@section('title','Login')
@section('content')

<div class="mb-6">
    <h1 class="font-display text-2xl font-bold text-white mb-1">Selamat datang kembali</h1>
    <p class="text-slate-400 text-sm">Masuk ke akun BeatBase Anda</p>
</div>

@if(request('expired'))
<div class="mb-4 bg-yellow-500/10 border border-yellow-500/20 text-yellow-400 text-sm px-4 py-3 rounded-xl">
    ⚠ Sesi Anda telah berakhir. Silakan login kembali.
</div>
@endif

<form action="{{ route('login.post') }}" method="POST">
@csrf

{{-- Email --}}
<div class="mb-4">
    <label class="block text-sm font-medium text-slate-300 mb-1.5">Email</label>
    <input type="email" name="email"
        value="{{ old('email', $rememberedEmail) }}"
        placeholder="nama@email.com"
        class="input-field w-full px-4 py-3 rounded-xl text-sm {{ $errors->has('email') ? 'error' : '' }}">
    @error('email')<p class="mt-1 text-red-400 text-xs">{{ $message }}</p>@enderror
</div>

{{-- Password --}}
<div class="mb-5">
    <label class="block text-sm font-medium text-slate-300 mb-1.5">Password</label>
    <div class="relative">
        <input type="password" id="pw" name="password" placeholder="Masukkan password"
            class="input-field w-full px-4 py-3 pr-11 rounded-xl text-sm {{ $errors->has('password') ? 'error' : '' }}">
        <button type="button" onclick="togglePw()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
        </button>
    </div>
    @error('password')<p class="mt-1 text-red-400 text-xs">{{ $message }}</p>@enderror
</div>

{{-- Remember Me --}}
<div class="flex items-center mb-6">
    <label class="flex items-center gap-2 cursor-pointer">
        <input type="checkbox" name="remember_me" id="remember_me"
            {{ $rememberedEmail ? 'checked' : '' }}
            class="w-4 h-4 rounded border-white/20 bg-white/10 accent-violet-500">
        <span class="text-sm text-slate-400">Ingat saya</span>
    </label>
</div>

<button type="submit" class="btn-primary w-full py-3 rounded-xl text-white font-semibold text-sm font-display">
    Masuk ke BeatBase
</button>
</form>

<p class="text-center text-sm text-slate-500 mt-6">
    Belum punya akun? <a href="{{ route('register') }}" class="text-violet-400 hover:text-violet-300 font-medium">Daftar sekarang</a>
</p>

@if(config('app.env') === 'local')
<div class="mt-5 p-4 rounded-xl" style="background:rgba(139,92,246,.08);border:1px solid rgba(139,92,246,.2)">
    <p class="text-xs text-slate-400 font-medium mb-2">Akun demo:</p>
    <p class="text-xs text-slate-500">admin@beatbase.com / owner@beatbase.com / customer@beatbase.com</p>
    <p class="text-xs text-slate-500">Password: <span class="text-slate-300">password</span></p>
</div>
@endif

<script>
function togglePw() {
    const f = document.getElementById('pw');
    f.type = f.type === 'password' ? 'text' : 'password';
}
</script>
@endsection
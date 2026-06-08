@extends('layouts.auth')
@section('title','Daftar')
@section('content')

<div class="mb-6">
    <h1 class="font-display text-2xl font-bold text-white mb-1">Buat akun baru</h1>
    <p class="text-slate-400 text-sm">Bergabung dengan BeatBase hari ini</p>
</div>

<form action="{{ route('register.post') }}" method="POST">
@csrf

{{-- Nama --}}
<div class="mb-4">
    <label class="block text-sm font-medium text-slate-300 mb-1.5">Nama Lengkap</label>
    <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama lengkap Anda"
        class="input-field w-full px-4 py-3 rounded-xl text-sm {{ $errors->has('nama') ? 'error' : '' }}">
    @error('nama')<p class="mt-1 text-red-400 text-xs">{{ $message }}</p>@enderror
</div>

{{-- Email --}}
<div class="mb-4">
    <label class="block text-sm font-medium text-slate-300 mb-1.5">Email</label>
    <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com"
        class="input-field w-full px-4 py-3 rounded-xl text-sm {{ $errors->has('email') ? 'error' : '' }}">
    @error('email')<p class="mt-1 text-red-400 text-xs">{{ $message }}</p>@enderror
</div>

{{-- Password --}}
<div class="mb-4">
    <label class="block text-sm font-medium text-slate-300 mb-1.5">Password</label>
    <input type="password" id="pw1" name="password" placeholder="Min. 6 karakter, huruf & angka"
        class="input-field w-full px-4 py-3 rounded-xl text-sm {{ $errors->has('password') ? 'error' : '' }}"
        oninput="checkStrength(this.value)">
    @error('password')<p class="mt-1 text-red-400 text-xs">{{ $message }}</p>@enderror
</div>

{{-- Konfirmasi Password --}}
<div class="mb-5">
    <label class="block text-sm font-medium text-slate-300 mb-1.5">Konfirmasi Password</label>
    <input type="password" id="pw2" name="password_confirmation" placeholder="Ulangi password"
        class="input-field w-full px-4 py-3 rounded-xl text-sm" oninput="checkMatch()">
    <p id="mtxt" class="mt-1 text-xs"></p>
</div>

{{-- Role --}}
<div class="mb-6">
    <input type="hidden" name="role" value="customer">
    <div class="p-4 rounded-xl text-center" style="background:rgba(139,92,246,.08);border:1px solid rgba(139,92,246,.2)">
        <p class="text-sm font-medium text-white">Customer</p>
        <p class="text-xs text-slate-400 mt-0.5">Akun untuk booking studio</p>
    </div>
</div>

<button type="submit" class="btn-primary w-full py-3 rounded-xl text-white font-semibold text-sm font-display">
    Buat Akun
</button>
</form>

<p class="text-center text-sm text-slate-500 mt-6">
    Sudah punya akun? <a href="{{ route('login') }}" class="text-violet-400 hover:text-violet-300 font-medium">Masuk</a>
</p>

<script>
function checkStrength(v) {
    let s = 0;
    if(v.length>=6)s++; if(v.length>=10)s++; if(/[A-Z]/.test(v))s++; if(/[0-9]/.test(v))s++; if(/[^a-zA-Z0-9]/.test(v))s++;
    const l=[{w:'0%',c:'',t:''},{ w:'25%',c:'bg-red-500',t:'Sangat lemah'},{w:'50%',c:'bg-orange-500',t:'Lemah'},{w:'75%',c:'bg-yellow-500',t:'Cukup'},{w:'90%',c:'bg-green-400',t:'Kuat'},{w:'100%',c:'bg-green-500',t:'Sangat kuat'}];
    const lv = v.length===0?l[0]:l[Math.max(1,Math.min(s,5))];
    const bar=document.getElementById('sbar'); bar.className='h-full rounded-full transition-all duration-300 '+lv.c; bar.style.width=lv.w;
    document.getElementById('stxt').textContent=lv.t;
}
function checkMatch() {
    const el=document.getElementById('mtxt');
    const ok=document.getElementById('pw1').value===document.getElementById('pw2').value;
    el.textContent=ok?'✓ Password cocok':'✗ Password tidak cocok';
    el.className='mt-1 text-xs '+(ok?'text-green-400':'text-red-400');
}
</script>
@endsection
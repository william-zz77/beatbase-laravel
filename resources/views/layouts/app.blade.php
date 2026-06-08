<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Dashboard') — BeatBase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family:'Inter',sans-serif; background:#0f0f18; color:#cbd5e1; }
        .font-display { font-family:'Space Grotesk',sans-serif; }
        aside { background:#0d0d14; border-right:1px solid rgba(255,255,255,.06); }
        .nav-link { display:flex; align-items:center; gap:10px; padding:10px 16px; border-radius:10px; font-size:.875rem; font-weight:500; color:rgba(148,163,184,.8); transition:all .15s; }
        .nav-link:hover { background:rgba(255,255,255,.06); color:#f1f5f9; }
        .nav-link.active { background:rgba(124,58,237,.2); color:#a78bfa; }
        .card { background:rgba(255,255,255,.03); border:1px solid rgba(255,255,255,.07); border-radius:16px; }
        .form-input { background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.10); color:#f1f5f9; border-radius:10px; padding:10px 14px; font-size:.875rem; width:100%; transition:all .2s; }
        .form-input::placeholder { color:rgba(148,163,184,.4); }
        .form-input:focus { outline:none; border-color:rgba(139,92,246,.5); box-shadow:0 0 0 3px rgba(139,92,246,.12); }
        select.form-input option { background:#1e1e2e; color:#f1f5f9; }
        table { border-collapse:separate; border-spacing:0; width:100%; }
        th { background:rgba(255,255,255,.04); color:rgba(148,163,184,.7); font-size:.75rem; font-weight:600; letter-spacing:.05em; text-transform:uppercase; padding:12px 16px; border-bottom:1px solid rgba(255,255,255,.06); text-align:left; }
        td { padding:14px 16px; border-bottom:1px solid rgba(255,255,255,.04); font-size:.875rem; }
        tr:last-child td { border-bottom:none; }
        tr:hover td { background:rgba(255,255,255,.02); }
        .badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:20px; font-size:.75rem; font-weight:600; }
        .badge-pending   { background:rgba(234,179,8,.15);  color:#fbbf24; }
        .badge-confirmed { background:rgba(34,197,94,.15);  color:#4ade80; }
        .badge-cancelled { background:rgba(239,68,68,.15);  color:#f87171; }
        .badge-lunas     { background:rgba(34,197,94,.15);  color:#4ade80; }
        .badge-belum     { background:rgba(239,68,68,.15);  color:#f87171; }
        .badge-refund    { background:rgba(59,130,246,.15); color:#60a5fa; }
        .btn { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:8px; font-size:.875rem; font-weight:500; transition:all .2s; cursor:pointer; }
        .btn-violet { background:rgba(124,58,237,.8); color:#fff; }
        .btn-violet:hover { background:rgba(124,58,237,1); }
        .btn-sm { padding:5px 12px; font-size:.8rem; }
        .btn-danger { background:rgba(239,68,68,.15); color:#f87171; }
        .btn-danger:hover { background:rgba(239,68,68,.25); }
        .btn-ghost { background:rgba(255,255,255,.06); color:#cbd5e1; }
        .btn-ghost:hover { background:rgba(255,255,255,.1); }
        ::-webkit-scrollbar { width:6px; } ::-webkit-scrollbar-thumb { background:rgba(255,255,255,.1); border-radius:3px; }
    </style>
    @stack('styles')
</head>
<body class="flex min-h-screen">

{{-- Sidebar --}}
<aside class="w-60 shrink-0 flex flex-col fixed inset-y-0 left-0 z-30">
    <div class="p-5 border-b border-white/5">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-violet-500 to-purple-700 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z"/>
                </svg>
            </div>
            <div>
                <p class="font-display font-bold text-white text-sm">BeatBase</p>
                <p class="text-xs text-slate-500 capitalize">{{ auth()->user()->role }}</p>
            </div>
        </div>
    </div>
    <nav class="flex-1 p-3 space-y-0.5 overflow-y-auto">
        @yield('sidebar-nav')
    </nav>
    <div class="p-3 border-t border-white/5">
        <div class="flex items-center gap-3 px-3 py-2 mb-1">
            <div class="w-8 h-8 rounded-full bg-violet-600/30 flex items-center justify-center shrink-0">
                <span class="text-xs font-bold text-violet-300">{{ strtoupper(substr(auth()->user()->nama,0,2)) }}</span>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-medium text-white truncate">{{ auth()->user()->nama }}</p>
                <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link w-full" style="color:#f87171;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>

{{-- Main --}}
<main class="ml-60 flex-1 min-h-screen">
    <header class="sticky top-0 z-20 flex items-center justify-between px-8 py-4 border-b border-white/5" style="background:rgba(15,15,24,.85);backdrop-filter:blur(16px);">
        <div>
            <h1 class="font-display text-lg font-bold text-white">@yield('page-title','Dashboard')</h1>
            <p class="text-xs text-slate-500">@yield('page-subtitle','')</p>
        </div>
        <div class="flex items-center gap-3">@yield('topbar-actions')</div>
    </header>

    <div class="px-8 pt-4">
        @if(session('success'))
        <div class="flex items-center gap-3 bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl text-sm mb-4">
            ✓ {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="flex items-center gap-3 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm mb-4">
            ✗ {{ session('error') }}
        </div>
        @endif
    </div>

    <div class="px-8 pb-8 pt-2">
        @yield('content')
    </div>
</main>

{{-- Modal Hapus --}}
<div id="modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(0,0,0,.6);backdrop-filter:blur(4px);">
    <div class="card max-w-sm w-full p-6">
        <h3 class="font-display font-bold text-white text-lg mb-2">Konfirmasi Hapus</h3>
        <p id="modal-msg" class="text-slate-400 text-sm mb-6">Data ini akan dihapus permanen. Lanjutkan?</p>
        <div class="flex gap-3">
            <button onclick="closeModal()" class="btn btn-ghost flex-1">Batal</button>
            <form id="modal-form" method="POST" class="flex-1">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger w-full">Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(url, msg) {
    document.getElementById('modal-form').action = url;
    if(msg) document.getElementById('modal-msg').textContent = msg;
    document.getElementById('modal').classList.remove('hidden');
}
function closeModal() { document.getElementById('modal').classList.add('hidden'); }
document.getElementById('modal').addEventListener('click', e => { if(e.target===e.currentTarget) closeModal(); });
</script>
@stack('scripts')
</body>
</html>
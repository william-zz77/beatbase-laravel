<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') — BeatBase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
        .bg-auth {
            background-color: #0a0a0f;
            background-image:
                radial-gradient(ellipse at 20% 50%, rgba(139,92,246,.15) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(236,72,153,.10) 0%, transparent 40%);
        }
        .card-glass { background:rgba(255,255,255,.04); backdrop-filter:blur(24px); border:1px solid rgba(255,255,255,.08); }
        .input-field { background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.12); color:#f1f5f9; transition:all .2s; }
        .input-field::placeholder { color:rgba(148,163,184,.6); }
        .input-field:focus { outline:none; border-color:rgba(139,92,246,.6); box-shadow:0 0 0 3px rgba(139,92,246,.15); }
        .input-field.error { border-color:rgba(239,68,68,.6); }
        .btn-primary { background:linear-gradient(135deg,#7c3aed,#6d28d9); transition:all .2s; }
        .btn-primary:hover { background:linear-gradient(135deg,#8b5cf6,#7c3aed); transform:translateY(-1px); box-shadow:0 8px 25px rgba(124,58,237,.4); }
    </style>
</head>
<body class="bg-auth min-h-screen flex items-center justify-center p-4">

    @if(session('error'))
    <div id="flash" class="fixed top-4 right-4 z-50 bg-red-500/90 text-white px-4 py-3 rounded-xl shadow-lg text-sm max-w-sm">
        {{ session('error') }}
    </div>
    @endif
    @if(session('success'))
    <div id="flash" class="fixed top-4 right-4 z-50 bg-green-500/90 text-white px-4 py-3 rounded-xl shadow-lg text-sm max-w-sm">
        {{ session('success') }}
    </div>
    @endif

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 mb-2">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-500 to-purple-700 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z"/>
                    </svg>
                </div>
                <span class="font-display text-2xl font-bold text-white">BeatBase</span>
            </div>
            <p class="text-slate-400 text-sm">Studio Band Reservation System</p>
        </div>
        <div class="card-glass rounded-2xl p-8">
            @yield('content')
        </div>
    </div>

    <script>
        const f = document.getElementById('flash');
        if (f) setTimeout(() => { f.style.opacity='0'; f.style.transition='opacity .4s'; setTimeout(()=>f.remove(),400); }, 4000);
    </script>
</body>
</html>
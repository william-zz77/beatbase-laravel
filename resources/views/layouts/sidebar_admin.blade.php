<aside class="w-64 bg-white shadow-md fixed left-0 top-16 bottom-0 overflow-y-auto z-40">
    <nav class="p-4 space-y-1">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-3">Menu Utama</p>
        <a href="/admin/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->is('admin/dashboard') ? 'bg-purple-50 text-purple-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <a href="/admin/studio" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->is('admin/studio*') ? 'bg-purple-50 text-purple-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            Kelola Studio
        </a>
        <a href="/admin/reservasi" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->is('admin/reservasi*') ? 'bg-purple-50 text-purple-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Data Reservasi
        </a>
        <a href="/admin/pengaturan-jam" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->is('admin/pengaturan-jam') ? 'bg-purple-50 text-purple-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Setting Jam
        </a>
        <div class="border-t border-gray-200 my-3"></div>
        <a href="/logout" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-red-500 hover:bg-red-50 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            Logout
        </a>
    </nav>
</aside>
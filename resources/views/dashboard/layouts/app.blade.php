<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Workspace') — QIEVRA+</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            background-color: #fbfbfd;
            color: #1d1d1f;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col md:flex-row antialiased selection:bg-blue-600 selection:text-white">

    <!-- Sidebar Admin -->
    <aside class="w-full md:w-64 bg-white border-r border-zinc-200/80 flex flex-col justify-between p-5 shrink-0">
        <div class="space-y-6">
            <!-- Brand -->
            <div class="flex items-center space-x-2.5 pb-5 border-b border-zinc-100">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Qievra Plus" class="h-7 w-auto object-contain">
                <div>
                    <div class="flex items-center font-extrabold text-sm tracking-wider select-none">
                        <span class="text-[#0B1E48] tracking-widest">QIEVRA</span>
                        <span class="text-[#F59E0B] ml-0.5 text-base">+</span>
                    </div>
                    <span class="text-[10px] text-zinc-400 uppercase tracking-widest font-bold">Admin Workspace</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-1.5 text-xs font-semibold">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-[#0071e3] font-bold' : 'text-zinc-600 hover:bg-zinc-50 hover:text-zinc-950' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Ringkasan</span>
                </a>

                <a href="{{ route('dashboard.services.index') }}"
                   class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('dashboard.services.*') ? 'bg-blue-50 text-[#0071e3] font-bold' : 'text-zinc-600 hover:bg-zinc-50 hover:text-zinc-950' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <span>Katalog Layanan</span>
                </a>

                <a href="{{ route('dashboard.orders.index') }}"
                   class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('dashboard.orders.*') ? 'bg-blue-50 text-[#0071e3] font-bold' : 'text-zinc-600 hover:bg-zinc-50 hover:text-zinc-950' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <span>Pesanan & Berkas</span>
                </a>

                <a href="{{ route('home') }}" target="_blank"
                   class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-zinc-500 hover:bg-zinc-50 hover:text-zinc-900 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>Lihat Website Utama</span>
                </a>
            </nav>
        </div>

        <!-- Profil Admin & Logout -->
        <div class="pt-4 border-t border-zinc-100 flex items-center justify-between">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-full bg-zinc-900 text-white flex items-center justify-center font-bold text-xs">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <div class="text-xs font-bold text-zinc-900 truncate max-w-[100px]">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <div class="text-[10px] text-zinc-400 font-mono">Admin</div>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" title="Keluar" class="p-1.5 text-zinc-400 hover:text-red-600 transition rounded-lg hover:bg-red-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 p-6 sm:p-10 max-w-6xl overflow-x-hidden">
        @yield('content')
    </main>

</body>
</html>

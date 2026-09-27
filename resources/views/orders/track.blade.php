<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat & Status Pesanan — Aksara Plus</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #fafafa; color: #1d1d1f; }
        .glass-nav-light {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        }
        .glass-panel { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border: 1px solid rgba(0,0,0,0.06); }
        #mobile-menu {
            transition: max-height 0.4s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.35s ease, transform 0.35s ease;
        }
        #mobile-menu.menu-closed {
            max-height: 0px;
            opacity: 0;
            transform: translateY(-8px);
            pointer-events: none;
            overflow: hidden;
        }
        #mobile-menu.menu-open {
            max-height: 420px;
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
            overflow: hidden;
        }
    </style>
</head>
<body class="antialiased min-h-screen selection:bg-blue-600 selection:text-white flex flex-col justify-between">

    <!-- HEADER NAVBAR -->
    <header class="fixed top-0 left-0 w-full z-50 glass-nav-light transition duration-300" id="main-nav">
        <div class="max-w-6xl mx-auto px-6 h-14 flex items-center justify-between text-xs tracking-tight">

            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <img src="{{ asset('images/logo.png') }}"
                     alt="Logo QIEVRA Plus"
                     class="h-8 w-auto object-contain transition-transform duration-300 group-hover:scale-105">

                <div class="flex items-center tracking-wider font-extrabold text-lg select-none">
                    <span class="text-[#0B1E48] tracking-[0.18em]">QIEVRA</span>
                    <span class="text-[#F59E0B] ml-0.5 text-xl font-black -translate-y-0.5">+</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center space-x-7 font-medium text-zinc-600">
                <a href="{{ route('home') }}#services-slider" class="hover:text-[#0071e3] transition duration-200">
                    Layanan
                </a>
                <a href="{{ route('client.orders.track') }}" class="text-[#0071e3] font-bold flex items-center space-x-1.5">
                    <span>Cek Pesanan</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-[#0071e3]"></span>
                </a>
                <a href="{{ route('home') }}#faq" class="hover:text-[#0071e3] transition duration-200">
                    FAQ
                </a>
                <a href="https://api.whatsapp.com/send?phone=6282268925885&text=Halo%20Admin%20AKSARA+,%20saya%20ingin%20konsultasi%20layanan." target="_blank" class="hover:text-[#0071e3] transition duration-200 flex items-center space-x-1.5">
                    <span>Konsultasi Proyek</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                </a>
            </nav>

            <div class="hidden md:flex items-center space-x-3">
                @auth
                    @if (Auth::user()->role === 'admin' || Auth::user()->email === 'admin@aksaraplus.com')
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 bg-blue-50 text-[#0071e3] border border-blue-200 px-4 py-1.5 rounded-full text-xs font-semibold hover:bg-blue-100 transition shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#0071e3] animate-pulse"></span>
                            <span>Dashboard Admin</span>
                        </a>
                    @else
                        <div class="flex items-center space-x-2">
                            <span class="text-xs text-zinc-600 font-medium">Halo, <b>{{ Str::words(Auth::user()->name, 1, '') }}</b></span>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-[11px] text-zinc-400 hover:text-red-600 transition">Keluar</button>
                            </form>
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="flex items-center space-x-1.5 bg-zinc-900 text-white px-4 py-1.5 rounded-full text-xs font-semibold hover:bg-zinc-800 transition shadow-sm hover:shadow active:scale-95">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        <span>Masuk</span>
                    </a>
                @endauth
            </div>

            <button id="mobile-toggle" aria-label="Menu Mobile" class="md:hidden text-zinc-700 hover:text-black p-1.5 focus:outline-none transition-transform duration-200">
                <svg id="hamburger-icon" class="w-5 h-5 transition-transform duration-300 ease-out" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <div id="mobile-menu" class="md:hidden menu-closed bg-white/95 backdrop-blur-2xl border-b border-zinc-200/80 shadow-2xl">
            <div class="px-6 py-5 space-y-3">
                <a href="{{ route('home') }}#services-slider" class="mobile-nav-link block text-sm font-medium text-zinc-600 hover:text-[#0071e3] py-1.5 border-b border-zinc-100 transition duration-150">
                    Layanan
                </a>
                <a href="{{ route('client.orders.track') }}" class="mobile-nav-link flex items-center justify-between text-sm font-semibold text-[#0071e3] py-1.5 border-b border-zinc-100 transition duration-150">
                    <span>Lacak / Cek Riwayat Pesanan</span>
                    <span class="px-2 py-0.5 rounded-full bg-blue-50 text-[#0071e3] text-[10px] font-bold border border-blue-200">Aktif</span>
                </a>
                <a href="{{ route('home') }}#faq" class="mobile-nav-link block text-sm font-medium text-zinc-600 hover:text-[#0071e3] py-1.5 border-b border-zinc-100 transition duration-150">
                    FAQ
                </a>
                <a href="https://api.whatsapp.com/send?phone=6282268925885&text=Halo%20Admin%20AKSARA+,%20saya%20ingin%20konsultasi%20layanan." target="_blank" class="mobile-nav-link block text-sm font-medium text-zinc-600 hover:text-[#0071e3] py-1.5 border-b border-zinc-100 transition duration-150">
                    Konsultasi WhatsApp
                </a>

                <div class="pt-2">
                    @auth
                        @if (Auth::user()->role === 'admin' || Auth::user()->email === 'admin@aksaraplus.com')
                            <a href="{{ route('dashboard') }}" class="block text-center bg-blue-50 text-[#0071e3] border border-blue-200 py-2.5 rounded-full text-xs font-semibold shadow-sm">
                                Buka Dashboard Admin
                            </a>
                        @else
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-center bg-zinc-100 text-zinc-800 py-2.5 rounded-full text-xs font-semibold">Keluar</button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block text-center bg-zinc-900 text-white py-2.5 rounded-full text-xs font-semibold shadow-md active:scale-95 transition">
                            Masuk ke Akun
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="flex-1 max-w-6xl mx-auto w-full px-6 pt-24 pb-12 space-y-8">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-zinc-200/70">
            <div class="space-y-1">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest font-mono">Portal Mahasiswa</span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1d1d1f] tracking-tight">
                    Riwayat Pesanan & Berkas Saya
                </h1>
                <p class="text-xs sm:text-sm text-zinc-500 font-normal">
                    Masukkan nomor WhatsApp Anda untuk melihat seluruh antrean dan riwayat pengerjaan naskah/aplikasi.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}" class="px-4 py-2 rounded-full bg-white border border-zinc-200 text-xs font-semibold text-zinc-700 hover:bg-zinc-50 transition shadow-sm active:scale-95">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>

        <!-- Search Bar -->
        <section class="glass-panel p-4 sm:p-6 rounded-3xl shadow-[0_4px_24px_rgba(0,0,0,0.02)]">
            <form method="GET" action="{{ route('client.orders.track') }}" class="flex flex-col sm:flex-row items-center gap-3">
                <div class="relative w-full sm:flex-1">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-zinc-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" required
                           placeholder="Ketik Nomor WhatsApp Anda (contoh: 082268925885) atau Kode Order..."
                           class="w-full pl-11 pr-4 py-3 rounded-2xl border border-zinc-200 text-xs sm:text-sm font-medium focus:ring-2 focus:ring-[#0071e3] focus:outline-none bg-zinc-50/80 transition">
                </div>

                <div class="w-full sm:w-auto flex items-center gap-2">
                    <button type="submit"
                            class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-[#0071e3] hover:bg-[#0077ed] text-white text-xs font-bold transition shadow-[0_4px_12px_rgba(0,113,227,0.25)] active:scale-95 shrink-0">
                        Lihat Riwayat
                    </button>

                    @if(request('q'))
                        <a href="{{ route('client.orders.track') }}" class="px-4 py-3 rounded-2xl text-xs font-semibold text-zinc-500 hover:text-zinc-900 transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </section>

        <!-- Tabel History Pesanan Klien -->
        <section class="glass-panel rounded-3xl overflow-hidden shadow-[0_4px_24px_rgba(0,0,0,0.02)]">

            <div class="px-6 py-4 border-b border-zinc-100 flex items-center justify-between">
                <div class="text-xs font-bold text-zinc-900 tracking-tight">
                    @if($searched && count($orders) > 0)
                        Ditemukan {{ count($orders) }} Pesanan Terkait "{{ request('q') }}"
                    @else
                        Daftar Riwayat Pesanan
                    @endif
                </div>
                <span class="text-[11px] font-mono text-zinc-400">Arsip & Progres</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-zinc-100 bg-zinc-50/60 text-zinc-400 uppercase font-semibold text-[10px] tracking-wider">
                            <th class="py-4 px-6">ID Order</th>
                            <th class="py-4 px-6">Tanggal Pengajuan</th>
                            <th class="py-4 px-6">Layanan Dipesan</th>
                            <th class="py-4 px-6">Biaya Proyek</th>
                            <th class="py-4 px-6">Status Pengerjaan</th>
                            <th class="py-4 px-6 text-right">Aksi & Berkas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 font-medium text-zinc-600">
                        <?php if (count($orders) > 0): ?>
                            <?php foreach ($orders as$order): ?>
                                <tr class="hover:bg-zinc-50/70 transition group">
                                    <td class="py-4 px-6 font-mono font-bold text-zinc-900">
                                        <span class="px-2.5 py-1 rounded-lg bg-blue-50 text-[#0071e3] border border-blue-100 text-[11px]">
                                            {{ $order->order_code }}
                                        </span>
                                    </td>

                                    <td class="py-4 px-6 text-zinc-500">
                                        {{ $order->created_at ? $order->created_at->format('d M Y') : '-' }}
                                        <div class="text-[10px] text-zinc-400">{{ $order->created_at ? $order->created_at->format('H:i') : '' }} WIB</div>
                                    </td>

                                    <td class="py-4 px-6">
                                        <div class="font-bold text-zinc-900 leading-snug">
                                            {{ $order->service->title ?? ($order->service_title ?? 'Layanan Akademik') }}
                                        </div>
                                        @if($order->notes)
                                            <div class="text-[11px] text-zinc-400 mt-0.5 line-clamp-1">Catatan: {{ $order->notes }}</div>
                                        @endif
                                    </td>

                                    <td class="py-4 px-6 font-mono font-bold text-zinc-900">
                                        @if($order->price > 0)
                                            Rp {{ number_format($order->price, 0, ',', '.') }}
                                        @else
                                            <span class="text-zinc-400 font-normal">Menunggu Konfirmasi</span>
                                        @endif
                                    </td>

                                    <td class="py-4 px-6">
                                        @if ($order->status === 'Selesai')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Selesai
                                            </span>
                                        @elseif (in_array($order->status, ['Diproses', 'Proses']))
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-blue-50 text-[#0071e3] border border-blue-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#0071e3] animate-pulse"></span>
                                                Diproses
                                            </span>
                                        @elseif ($order->status === 'Revisi')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                Revisi
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-zinc-100 text-zinc-600 border border-zinc-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-zinc-400"></span>
                                                Pending
                                            </span>
                                        @endif
                                    </td>

                                    <td class="py-4 px-6 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            @if ($order->result_file_path)
                                                <a href="{{ route('client.orders.download', $order->order_code) }}"
   class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm active:scale-95 shrink-0">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
    <span>Unduh Berkas Sekarang</span>
</a>
                                            @endif
                                            <a href="{{ route('client.orders.detail', $order->order_code) }}"
                                               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-zinc-100 hover:bg-[#0071e3] hover:text-white text-zinc-700 text-[11px] font-semibold transition active:scale-95">
                                                <span>Rincian</span>
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php if ($searched): ?>
                                <tr>
                                    <td colspan="6" class="py-14 text-center">
                                        <div class="w-10 h-10 rounded-full bg-red-50 text-red-500 flex items-center justify-center mx-auto mb-2 text-sm font-bold">
                                            !
                                        </div>
                                        <div class="text-xs font-bold text-zinc-800">Tidak Ada Riwayat Pesanan</div>
                                        <div class="text-[11px] text-zinc-400 mt-0.5">Tidak ditemukan pesanan dengan kata kunci "{{ request('q') }}". Pastikan nomor WhatsApp sama saat mengajukan pesanan.</div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="py-16 text-center">
                                        <div class="w-10 h-10 rounded-full bg-zinc-100 text-zinc-400 flex items-center justify-center mx-auto mb-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <div class="text-xs font-bold text-zinc-700">Cek Seluruh Riwayat Pesanan Anda</div>
                                        <div class="text-[11px] text-zinc-400 mt-0.5">Ketik nomor WhatsApp yang Anda gunakan saat memesan untuk menampilkan seluruh riwayat pengerjaan.</div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </section>

    </main>

    <!-- FOOTER -->
    <footer class="border-t border-zinc-200/80 bg-white/70 backdrop-blur text-zinc-400 text-[11px] py-4 text-center">
        © {{ date('Y') }} Aksara Plus. Seluruh hak cipta dilindungi undang-undang.
    </footer>

    <!-- INTERACTIVE SCRIPTS -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mobileToggle = document.getElementById('mobile-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburgerIcon = document.getElementById('hamburger-icon');

            if (mobileToggle && mobileMenu) {
                mobileToggle.addEventListener('click', () => {
                    const isOpen = mobileMenu.classList.contains('menu-open');

                    if (isOpen) {
                        mobileMenu.classList.remove('menu-open');
                        mobileMenu.classList.add('menu-closed');
                        hamburgerIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>`;
                        hamburgerIcon.style.transform = 'rotate(0deg)';
                    } else {
                        mobileMenu.classList.remove('menu-closed');
                        mobileMenu.classList.add('menu-open');
                        hamburgerIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>`;
                        hamburgerIcon.style.transform = 'rotate(90deg)';
                    }
                });
            }
        });
    </script>
</body>
</html>

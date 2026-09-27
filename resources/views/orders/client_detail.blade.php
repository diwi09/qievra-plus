<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rincian Pesanan {{ $order->order_code }} — Aksara Plus</title>
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
        .glass-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border: 1px solid rgba(0, 0, 0, 0.07); }
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

            <!-- KIRI: Brand Logo & Text -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <img src="{{ asset('images/logo.png') }}"
                     alt="Logo Aksara Plus"
                     class="h-8 w-auto object-contain transition-transform duration-300 group-hover:scale-105">

                <div class="flex items-center tracking-wider font-extrabold text-lg select-none">
                    <span class="text-[#0B1E48] tracking-[0.18em]">QIEVRA</span>
                    <span class="text-[#F59E0B] ml-0.5 text-xl font-black -translate-y-0.5">+</span>
                </div>
            </a>

            <!-- TENGAH: Menu Navigasi -->
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

            <!-- KANAN: Login / Status Pengguna -->
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

            <!-- Hamburger Button Mobile -->
            <button id="mobile-toggle" aria-label="Menu Mobile" class="md:hidden text-zinc-700 hover:text-black p-1.5 focus:outline-none transition-transform duration-200">
                <svg id="hamburger-icon" class="w-5 h-5 transition-transform duration-300 ease-out" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Drawer -->
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
    <main class="flex-1 max-w-4xl mx-auto w-full px-4 sm:px-6 pt-24 pb-14 space-y-6">

        <!-- Top Action Bar -->
        <div class="flex items-center justify-between">
            <a href="{{ route('client.orders.track', ['q' => $order->client_whatsapp]) }}"
               class="inline-flex items-center gap-1.5 text-xs font-semibold text-zinc-600 hover:text-[#0071e3] transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                <span>Kembali ke Riwayat Pesanan</span>
            </a>

            <span class="text-[11px] font-mono font-medium text-zinc-400">
                Diajukan pada: {{ $order->created_at ? $order->created_at->format('d M Y, H:i') : '-' }} WIB
            </span>
        </div>

        <!-- Main Card Detail -->
        <div class="glass-card rounded-[32px] p-6 sm:p-10 shadow-[0_12px_40px_rgba(0,0,0,0.04)] space-y-8">

            <!-- Header Kartu: Kode & Status -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-zinc-100">
                <div>
                    <span class="text-[10px] font-mono font-bold tracking-widest text-zinc-400 uppercase">Detail Pesanan Layanan</span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-zinc-900 tracking-tight mt-0.5">
                        {{ $order->order_code }}
                    </h1>
                </div>

                <div>
                    @if ($order->status === 'Selesai')
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Selesai — Siap Diunduh
                        </span>
                    @elseif (in_array($order->status, ['Diproses', 'Proses']))
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold bg-blue-50 text-[#0071e3] border border-blue-200 shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-[#0071e3] animate-pulse"></span>
                            Sedang Dikerjakan Tim
                        </span>
                    @elseif ($order->status === 'Revisi')
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200 shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            Tahap Perbaikan / Revisi
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold bg-zinc-100 text-zinc-600 border border-zinc-200 shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-zinc-400"></span>
                            Menunggu Konfirmasi Tim
                        </span>
                    @endif
                </div>
            </div>

            <!-- Progres Pelacakan Step-by-Step -->
            <div class="p-6 rounded-2xl bg-zinc-50 border border-zinc-100">
                <span class="text-[11px] font-bold text-zinc-400 uppercase tracking-wider block mb-4">Alur Pengerjaan Layanan</span>
                <div class="grid grid-cols-4 gap-2 text-center">

                    <!-- Step 1: Diajukan -->
                    <div class="space-y-1.5">
                        <div class="w-8 h-8 rounded-full bg-emerald-500 text-white text-xs font-bold flex items-center justify-center mx-auto shadow-sm">
                            ✓
                        </div>
                        <div class="text-[11px] font-bold text-zinc-800">Diajukan</div>
                        <div class="text-[10px] text-zinc-400 hidden sm:block">Pesanan masuk</div>
                    </div>

                    <!-- Step 2: Diproses -->
                    <div class="space-y-1.5">
                        <div class="w-8 h-8 rounded-full {{ in_array($order->status, ['Diproses', 'Proses', 'Revisi', 'Selesai']) ? 'bg-blue-600 text-white' : 'bg-zinc-200 text-zinc-500' }} text-xs font-bold flex items-center justify-center mx-auto shadow-sm">
                            2
                        </div>
                        <div class="text-[11px] font-bold {{ in_array($order->status, ['Diproses', 'Proses', 'Revisi', 'Selesai']) ? 'text-zinc-800' : 'text-zinc-400' }}">Diproses</div>
                        <div class="text-[10px] text-zinc-400 hidden sm:block">Sedang diolah</div>
                    </div>

                    <!-- Step 3: Revisi -->
                    <div class="space-y-1.5">
                        <div class="w-8 h-8 rounded-full {{ in_array($order->status, ['Revisi', 'Selesai']) ? ($order->status === 'Revisi' ? 'bg-amber-500 text-white' : 'bg-emerald-500 text-white') : 'bg-zinc-200 text-zinc-500' }} text-xs font-bold flex items-center justify-center mx-auto shadow-sm">
                            3
                        </div>
                        <div class="text-[11px] font-bold {{ in_array($order->status, ['Revisi', 'Selesai']) ? 'text-zinc-800' : 'text-zinc-400' }}">Revisi</div>
                        <div class="text-[10px] text-zinc-400 hidden sm:block">Koreksi arahan</div>
                    </div>

                    <!-- Step 4: Selesai -->
                    <div class="space-y-1.5">
                        <div class="w-8 h-8 rounded-full {{ $order->status === 'Selesai' ? 'bg-emerald-500 text-white' : 'bg-zinc-200 text-zinc-500' }} text-xs font-bold flex items-center justify-center mx-auto shadow-sm">
                            4
                        </div>
                        <div class="text-[11px] font-bold {{ $order->status === 'Selesai' ? 'text-zinc-800' : 'text-zinc-400' }}">Selesai</div>
                        <div class="text-[10px] text-zinc-400 hidden sm:block">Unduh naskah</div>
                    </div>

                </div>
            </div>

            <!-- Grid Rincian Pesanan & Pemesan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">

                <!-- Info Layanan -->
                <div class="p-5 rounded-2xl bg-zinc-50 border border-zinc-100 space-y-3">
                    <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider block">Layanan Pilihan</span>
                    <div>
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold uppercase tracking-wider bg-blue-100 text-[#0071e3]">
                            {{ $order->service->badge ?? 'LAYANAN TERPILIH' }}
                        </span>
                        <h3 class="text-base font-bold text-zinc-900 mt-1">
                            {{ $order->service->title ?? ($order->service_title ?? 'Layanan Riset Akademik') }}
                        </h3>
                    </div>

                    <div class="pt-2 border-t border-zinc-200/60 flex justify-between items-center">
                        <span class="text-zinc-500">Biaya Layanan:</span>
                        <span class="font-mono font-extrabold text-sm text-zinc-900">
                            @if ($order->price > 0)
                                Rp {{ number_format($order->price, 0, ',', '.') }}
                            @else
                                <span class="text-zinc-400 font-normal">Menunggu Konfirmasi Tim</span>
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Info Mahasiswa / Klien -->
                <div class="p-5 rounded-2xl bg-zinc-50 border border-zinc-100 space-y-2.5">
                    <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider block">Identitas Klien</span>
                    <div class="flex justify-between">
                        <span class="text-zinc-500">Nama Lengkap:</span>
                        <span class="font-bold text-zinc-900">{{ $order->client_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-zinc-500">Kampus / Instansi:</span>
                        <span class="font-semibold text-zinc-700">{{ $order->client_campus ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-zinc-500">Nomor WhatsApp:</span>
                        <span class="font-mono font-semibold text-zinc-800">{{ $order->client_whatsapp ?? '-' }}</span>
                    </div>
                </div>

            </div>

            <!-- Catatan Klien & File Unggahan Awal -->
            <div class="p-5 rounded-2xl bg-zinc-50 border border-zinc-100 space-y-3 text-xs">
                <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider block">Kebutuhan & Catatan Mahasiswa</span>
                <p class="text-zinc-700 leading-relaxed italic font-normal">
                    "{{ $order->notes ?? 'Tidak ada catatan tambahan yang dilampirkan.' }}"
                </p>

                @if ($order->client_file_path)
                    <div class="pt-2 flex items-center justify-between border-t border-zinc-200/60">
                        <span class="text-zinc-500 text-[11px]">Berkas Awal Mahasiswa:</span>
                        <a href="{{ Storage::url($order->client_file_path) }}" target="_blank"
                           class="inline-flex items-center gap-1.5 text-[#0071e3] font-bold hover:underline text-[11px]">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Lihat Berkas Yang Diunggah</span>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Catatan dari Admin / Mentor -->
            @if ($order->admin_note)
                <div class="p-5 rounded-2xl bg-blue-50/60 border border-blue-100 space-y-1.5 text-xs">
                    <span class="font-bold text-[#0071e3] flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Arahan & Catatan Tim Aksara+
                    </span>
                    <p class="text-zinc-700 leading-relaxed font-normal">
                        {{ $order->admin_note }}
                    </p>
                </div>
            @endif

            <!-- Berkas Hasil Akhir (Download Area) -->
            <div class="space-y-2 pt-2">
                <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider block">Berkas Hasil Pengerjaan</span>
                @if ($order->result_file_path)
                    <div class="p-5 rounded-2xl bg-emerald-50 border border-emerald-200 flex flex-col sm:flex-row gap-4 sm:items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-bold text-lg shadow-sm">
                                ↓
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-emerald-950">Berkas Hasil Telah Tersedia</h4>
                                <span class="text-[11px] text-emerald-700">Naskah/source code revisi terbaru siap untuk diunduh dan dipelajari.</span>
                            </div>
                        </div>
                        <a href="{{ Storage::url($order->result_file_path) }}" download target="_blank"
                           class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm active:scale-95 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Unduh Berkas Sekarang</span>
                        </a>
                    </div>
                @else
                    <div class="p-5 rounded-2xl bg-zinc-50 border border-zinc-100 text-xs text-zinc-400 text-center font-medium">
                        Berkas hasil pengerjaan akan otomatis muncul di sini segera setelah tim mengunggahnya.
                    </div>
                @endif
            </div>

            <!-- Footer Card: Tombol WhatsApp & Beranda -->
            <div class="pt-6 border-t border-zinc-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                <a href="{{ route('client.orders.track', ['q' => $order->client_whatsapp]) }}"
                   class="text-xs font-semibold text-zinc-500 hover:text-zinc-800 transition">
                    ← Kembali ke Riwayat Pesanan
                </a>

                <a href="https://api.whatsapp.com/send?phone=6282268925885&text=Halo%20Admin%20AKSARA+,%20saya%20ingin%20menanyakan%20progres%20order%20{{ $order->order_code }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-[#25D366] hover:bg-[#20bd5a] text-white text-xs font-bold transition shadow-sm active:scale-95">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                    </svg>
                    <span>Konsultasi Progres via WhatsApp</span>
                </a>
            </div>

        </div>

    </main>

    <!-- FOOTER -->
    <footer class="border-t border-zinc-200/80 bg-white/70 backdrop-blur text-zinc-400 text-[11px] py-4 text-center">
        © {{ date('Y') }} Aksara Plus. Seluruh hak cipta dilindungi undang-undang.
    </footer>

    <!-- INTERACTIVE SCRIPT: Mobile Menu Toggle -->
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

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qievra Plus — Solusi Riset Akademik & Rekayasa Digital</title>

    <meta name="description" content="Layanan terpadu olah data statistik, editing skripsi & tesis, pembuatan software/aplikasi tugas akhir, dan desain kreatif.">
    <meta name="theme-color" content="#ffffff">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            apple: {
                                white: '#ffffff',
                                canvas: '#fafafa',
                                border: 'rgba(0, 0, 0, 0.08)',
                                text: '#1d1d1f',
                                muted: '#6e6e73',
                                blue: '#0071e3',
                                'blue-hover': '#0077ed'
                            }
                        },
                        animation: {
                            'float-subtle': 'float 7s ease-in-out infinite',
                            'pulse-slow': 'pulse 8s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        },
                        keyframes: {
                            float: {
                                '0%, 100%': { transform: 'translateY(0px)' },
                                '50%': { transform: 'translateY(-12px)' },
                            }
                        }
                    }
                }
            }
        </script>
    @endif

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #ffffff;
            color: #1d1d1f;
            overflow-x: hidden;
        }

        /* Opening Intro Preloader Overlay */
        #intro-preloader {
            position: fixed;
            inset: 0;
            z-index: 99999;
            background: #09090b;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.9s cubic-bezier(0.77, 0, 0.175, 1), opacity 0.9s ease;
        }
        #intro-preloader.hide-intro {
            transform: translateY(-100%);
            pointer-events: none;
        }

        /* Kotak Bingkai Animasi Teks Berganti dari Atas ke Bawah */
        .greeting-viewport {
            height: 72px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        #greeting-text {
            display: inline-block;
            transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.22s ease;
            will-change: transform, opacity;
        }

        .slide-down-out {
            transform: translateY(32px) !important;
            opacity: 0 !important;
        }
        .slide-down-in {
            transform: translateY(0px) !important;
            opacity: 1 !important;
        }
        .slide-down-ready {
            transform: translateY(-32px) !important;
            opacity: 0 !important;
        }

        /* SCROLL REVEAL UTILITY CLASSES */
        .reveal-node {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.85s cubic-bezier(0.16, 1, 0.3, 1), transform 0.85s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .reveal-node.revealed {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
        }

        /* Staggered Delay Helpers */
        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }
        .delay-400 { transition-delay: 400ms; }

        .glass-nav-light {
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .glass-card-light {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(0, 0, 0, 0.06);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .glass-card-light:hover {
            transform: translateY(-6px);
            border-color: rgba(0, 113, 227, 0.25);
            box-shadow: 0 24px 48px -12px rgba(0, 113, 227, 0.1);
        }

        .text-gradient-dark {
            background: linear-gradient(180deg, #111113 0%, #3e3e44 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .text-gradient-blue {
            background: linear-gradient(135deg, #0071e3 0%, #6366f1 50%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .ambient-blob-1 {
            background: radial-gradient(circle, rgba(0, 113, 227, 0.14) 0%, rgba(99, 102, 241, 0.08) 45%, transparent 70%);
        }

        .ambient-blob-2 {
            background: radial-gradient(circle, rgba(244, 63, 94, 0.09) 0%, rgba(249, 115, 22, 0.05) 40%, transparent 70%);
        }

        .ambient-blob-3 {
            background: radial-gradient(circle, rgba(16, 185, 129, 0.08) 0%, rgba(59, 130, 246, 0.05) 45%, transparent 70%);
        }

        .slide-element {
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

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
            max-height: 360px;
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
            overflow: hidden;
        }
    </style>
</head>
<body class="selection:bg-blue-600 selection:text-white antialiased">

    <!-- OPENING INTRO (Cinematic Vertical Downward Roll) -->
    <div id="intro-preloader">
        <div class="relative flex items-center justify-center flex-col px-6">
            <div class="flex items-center space-x-3.5 select-none">
                <span class="w-3.5 h-3.5 rounded-full bg-[#0071e3] shadow-[0_0_12px_#0071e3] animate-pulse"></span>
                <div class="greeting-viewport">
                    <span id="greeting-text" class="text-white text-3xl sm:text-5xl md:text-6xl font-extrabold tracking-tight font-sans slide-down-in">
                        Halo
                    </span>
                </div>
            </div>
            <div class="mt-4 text-[10px] font-mono tracking-widest text-zinc-500 uppercase flex items-center gap-2">
                <span>QIEVRA STUDIO</span>
                <span class="text-zinc-600">•</span>
                <span class="text-blue-500">DIGITAL ARCHITECTURE</span>
            </div>
        </div>
    </div>

    <!-- Ambient Glowing Light Orbs -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[950px] h-[650px] rounded-full ambient-blob-1 blur-3xl animate-pulse-slow"></div>
        <div class="absolute top-[650px] -right-40 w-[650px] h-[650px] rounded-full ambient-blob-2 blur-3xl animate-float-subtle"></div>
        <div class="absolute top-[1400px] -left-40 w-[750px] h-[750px] rounded-full ambient-blob-3 blur-3xl"></div>
    </div>

    <!-- HEADER NAVBAR ELEGAN -->
    <header class="fixed top-0 left-0 w-full z-50 glass-nav-light transition-all duration-300" id="main-nav">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between text-xs tracking-tight">

            <!-- KIRI: Brand Logo & Text -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <img src="{{ asset('images/logo.png') }}"
                     alt="Logo Qievra Plus"
                     class="h-8 w-auto object-contain transition-transform duration-300 group-hover:scale-105">

                <div class="flex items-center tracking-wider font-extrabold text-lg select-none">
                    <span class="text-[#0B1E48] tracking-[0.18em]">QIEVRA</span>
                    <span class="text-[#F59E0B] ml-0.5 text-xl font-black -translate-y-0.5 transition-transform duration-300 group-hover:rotate-12">+</span>
                </div>
            </a>

            <!-- TENGAH: Menu Navigasi -->
            <nav class="hidden md:flex items-center space-x-8 font-medium text-zinc-600">
                <a href="#services-slider" class="hover:text-[#0071e3] transition duration-200">
                    Layanan
                </a>
                <a href="#keunggulan" class="hover:text-[#0071e3] transition duration-200">
                    Keunggulan
                </a>
                <a href="#faq" class="hover:text-[#0071e3] transition duration-200">
                    FAQ
                </a>
            </nav>

            <!-- KANAN: Tombol Konsultasi Estetik -->
            <div class="hidden md:flex items-center space-x-3">
                <a href="https://api.whatsapp.com/send?phone=6282268925885&text=Halo%20Admin%20QIEVRA+,%20saya%20ingin%20konsultasi%20layanan."
                   target="_blank"
                   class="relative group inline-flex items-center space-x-2 bg-zinc-950 text-white px-5 py-2.5 rounded-full text-xs font-semibold hover:bg-zinc-800 transition shadow-sm hover:shadow-md active:scale-95">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Konsultasi Cepat</span>
                    <svg class="w-3.5 h-3.5 text-zinc-400 group-hover:text-white transition group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <!-- Hamburger Button Mobile -->
            <button id="mobile-toggle" aria-label="Menu Mobile" class="md:hidden text-zinc-700 hover:text-black p-2 focus:outline-none transition">
                <svg id="hamburger-icon" class="w-5 h-5 transition-transform duration-300 ease-out" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Drawer -->
        <div id="mobile-menu" class="md:hidden menu-closed bg-white/95 backdrop-blur-2xl border-b border-zinc-200/80 shadow-2xl">
            <div class="px-6 py-5 space-y-3">
                <a href="#services-slider" class="mobile-nav-link block text-sm font-medium text-zinc-600 hover:text-[#0071e3] py-2 border-b border-zinc-100 transition">
                    Layanan
                </a>
                <a href="#keunggulan" class="mobile-nav-link block text-sm font-medium text-zinc-600 hover:text-[#0071e3] py-2 border-b border-zinc-100 transition">
                    Keunggulan
                </a>
                <a href="#faq" class="mobile-nav-link block text-sm font-medium text-zinc-600 hover:text-[#0071e3] py-2 border-b border-zinc-100 transition">
                    FAQ
                </a>

                <div class="pt-3">
                    <a href="https://api.whatsapp.com/send?phone=6282268925885&text=Halo%20Admin%20QIEVRA+,%20saya%20ingin%20konsultasi%20layanan."
                       target="_blank"
                       class="flex items-center justify-center space-x-2 w-full text-center bg-zinc-950 text-white py-3 rounded-full text-xs font-semibold shadow-md active:scale-95 transition">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Konsultasi WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- HERO SECTION (Animasi Bertingkat / Staggered Reveal) -->
    <section id="hero" class="relative z-10 flex flex-col justify-center items-center text-center px-6 pt-32 pb-16">

        <div class="reveal-node inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-zinc-100/80 border border-zinc-200/80 text-zinc-700 text-xs font-medium mb-6 shadow-sm">
            <span class="flex h-2 w-2 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
            </span>
            <span>Studio Rekayasa Digital & Naskah Akademik</span>
        </div>

        <h1 class="reveal-node delay-100 text-4xl sm:text-6xl md:text-7xl font-extrabold tracking-tight max-w-4xl text-gradient-dark leading-[1.12]">
            Solusi Digital & Akademik <br class="hidden sm:inline">
            <span class="text-gradient-blue">dalam Satu Tempat.</span>
        </h1>

        <p class="reveal-node delay-200 mt-6 text-base sm:text-lg text-zinc-500 max-w-2xl font-normal leading-relaxed">
            Membantu penyelesaian olah data, editing dokumen akademik, perancangan aplikasi, hingga karya visual kreatif dengan kualitas teruji dan jadwal tepat waktu.
        </p>

        <div class="reveal-node delay-300 mt-8 flex flex-col sm:flex-row items-center justify-center gap-3 text-sm font-medium">
            <a href="#services-slider" class="w-full sm:w-auto bg-[#0071e3] text-white px-8 py-3.5 rounded-full hover:bg-blue-600 transition flex items-center justify-center space-x-2 shadow-lg shadow-blue-500/25 active:scale-95 group">
                <span>Eksplorasi Layanan</span>
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            <a href="https://api.whatsapp.com/send?phone=6282268925885&text=Halo%20Admin%20QIEVRA+,%20saya%20mau%20tanya%20seputar%20bimbingan%20dan%20proyek."
               target="_blank"
               class="w-full sm:w-auto px-8 py-3.5 rounded-full bg-white hover:bg-zinc-50 text-zinc-800 transition flex items-center justify-center space-x-2 border border-zinc-200/90 shadow-sm active:scale-95">
                <svg class="w-4 h-4 text-emerald-500 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                <span>Tanya via WhatsApp</span>
            </a>
        </div>
    </section>

    <!-- SECTION KEUNGGULAN (Animated Staggered Cards) -->
    <section id="keunggulan" class="py-12 max-w-6xl mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="reveal-node delay-100 glass-card-light p-7 rounded-3xl space-y-3">
                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-[#0071e3] flex items-center justify-center font-bold text-sm">
                    01
                </div>
                <h3 class="text-base font-bold text-zinc-900 tracking-tight">Presisi & Bebas Plagiasi</h3>
                <p class="text-xs text-zinc-500 leading-relaxed">
                    Setiap naskah, kode aplikasi, dan analisis data disusun melalui riset orisinal dengan standar metodologi teruji.
                </p>
            </div>

            <div class="reveal-node delay-200 glass-card-light p-7 rounded-3xl space-y-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm">
                    02
                </div>
                <h3 class="text-base font-bold text-zinc-900 tracking-tight">Garansi Pendampingan Revisi</h3>
                <p class="text-xs text-zinc-500 leading-relaxed">
                    Dukungan fleksibel hingga tahap sidang dan seminar akhir dengan respon cepat dari tim mentor teknis.
                </p>
            </div>

            <div class="reveal-node delay-300 glass-card-light p-7 rounded-3xl space-y-3">
                <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-sm">
                    03
                </div>
                <h3 class="text-base font-bold text-zinc-900 tracking-tight">Privasi Data 100% Aman</h3>
                <p class="text-xs text-zinc-500 leading-relaxed">
                    Kerahasiaan data mentah dan materi penelitian Anda dijaga penuh tanpa pernah dibagikan kepada pihak ketiga.
                </p>
            </div>
        </div>
    </section>

    <!-- SERVICES SLIDER SECTION (Animated Showcase) -->
    <section id="services-slider" class="py-14 max-w-6xl mx-auto px-6 relative z-10">
        <div class="reveal-node text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-semibold text-blue-600 tracking-wider uppercase">Katalog Layanan</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold mt-1 text-gradient-dark tracking-tight">
                Fokus Pada Solusi Anda.
            </h2>
            <p class="text-zinc-500 text-sm sm:text-base mt-2">
                Pilih kebutuhan riset atau implementasi sistem digital Anda dengan pengerjaan profesional.
            </p>
        </div>

        <div id="slider-box" class="reveal-node delay-200 relative rounded-[32px] overflow-hidden border border-zinc-200/80 shadow-2xl group bg-zinc-950">
            <div class="relative w-full h-[520px] sm:h-[460px] overflow-hidden">

                @forelse ($services ?? [] as $index => $service)
                    @php
                        $colorMaps = [
                            'blue'    => ['bg' => 'bg-blue-500/20', 'text' => 'text-blue-400', 'border' => 'border-blue-400/30', 'btn' => 'bg-[#0071e3] hover:bg-blue-600 shadow-blue-500/40'],
                            'purple'  => ['bg' => 'bg-purple-500/20', 'text' => 'text-purple-400', 'border' => 'border-purple-400/30', 'btn' => 'bg-purple-600 hover:bg-purple-700 shadow-purple-500/40'],
                            'emerald' => ['bg' => 'bg-emerald-500/20', 'text' => 'text-emerald-400', 'border' => 'border-emerald-400/30', 'btn' => 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-500/40'],
                            'amber'   => ['bg' => 'bg-amber-500/20', 'text' => 'text-amber-400', 'border' => 'border-amber-400/30', 'btn' => 'bg-amber-600 hover:bg-amber-700 shadow-amber-500/40'],
                        ];
                        $theme = $colorMaps[$service->badge_color] ?? $colorMaps['blue'];
                    @endphp

                    <div class="slide-element absolute inset-0 w-full h-full {{ $index === 0 ? 'opacity-100 transform translate-x-0' : 'opacity-0 transform translate-x-full pointer-events-none' }}"
                         data-index="{{ $index }}">
                        <img src="{{ $service->image_url }}"
                             alt="{{ $service->title }}"
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/75 to-black/30 lg:bg-gradient-to-r lg:from-black/95 lg:via-black/70 lg:to-transparent"></div>

                        <div class="absolute inset-0 flex flex-col justify-end lg:justify-center p-6 sm:p-12 max-w-2xl text-left">
                            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-md {{ $theme['bg'] }} {{ $theme['text'] }} border {{ $theme['border'] }} text-xs font-extrabold w-fit mb-3">
                                <span>{{ $service->badge }}</span>
                            </div>
                            <h3 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight leading-snug">
                                {{ $service->title }}
                            </h3>
                            <p class="text-xs sm:text-sm text-zinc-300 mt-2 leading-relaxed">
                                {{ $service->description }}
                            </p>

                            <div class="mt-6">
                                <a href="https://api.whatsapp.com/send?phone=6282268925885&text=Halo%20Admin%20QIEVRA+,%20saya%20tertarik%20dengan%20layanan%20{{ urlencode($service->title) }}."
                                   target="_blank"
                                   class="inline-flex items-center space-x-2 {{ $theme['btn'] }} text-white px-6 py-3 rounded-full text-xs font-bold transition shadow-lg active:scale-95 group">
                                    <span>Konsultasikan Layanan</span>
                                    <span class="transition-transform group-hover:translate-x-1">→</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex items-center justify-center h-full text-zinc-400 text-sm">
                        Belum ada data layanan aktif di sistem.
                    </div>
                @endforelse

            </div>

            <!-- SLIDER CONTROLS -->
            <div class="absolute bottom-4 right-4 sm:bottom-6 sm:right-8 z-20 flex items-center space-x-4 bg-black/60 backdrop-blur-xl px-4 py-2 rounded-full border border-white/20 shadow-lg">
                <div class="flex items-center space-x-2" id="slider-dots">
                    @foreach ($services ?? [] as $index => $service)
                        <button class="slider-dot {{ $index === 0 ? 'w-6 bg-blue-500' : 'w-2 bg-white/30' }} h-1.5 rounded-full transition-all duration-300"
                                data-slide="{{ $index }}"
                                aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>

                <div class="w-px h-3 bg-white/20"></div>

                <div class="flex items-center space-x-1">
                    <button id="prev-slide" aria-label="Sebelumnya" class="text-white/80 hover:text-white p-1 transition active:scale-90">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button id="next-slide" aria-label="Berikutnya" class="text-white/80 hover:text-white p-1 transition active:scale-90">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            <div class="absolute top-0 left-0 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 z-30 transition-all duration-[4000ms] ease-linear w-0" id="slide-progress"></div>
        </div>
    </section>

    <!-- FAQ SECTION (Animated Accordions) -->
    <section id="faq" class="py-12 max-w-4xl mx-auto px-6 relative z-10">
        <div class="reveal-node text-center mb-8">
            <span class="text-xs font-semibold text-blue-600 tracking-wider uppercase">Tanya Jawab</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold mt-1 text-gradient-dark tracking-tight">FAQ Seputar Bimbingan</h2>
        </div>

        <div class="space-y-3">
            <div class="reveal-node delay-100 glass-card-light rounded-2xl overflow-hidden">
                <button class="faq-toggle w-full p-5 text-left flex justify-between items-center focus:outline-none">
                    <span class="font-semibold text-zinc-900 text-sm sm:text-base">Layanan apa saja yang ditawarkan QIEVRA+?</span>
                    <span class="faq-icon text-zinc-400 text-xl font-bold transition duration-300">＋</span>
                </button>
                <div class="faq-content hidden px-5 pb-5 text-xs sm:text-sm text-zinc-600 leading-relaxed border-t border-zinc-100 pt-3">
                    Kami menyediakan layanan pembuatan software web & mobile, olah data statistik, pendampingan naskah skripsi/tesis, serta desain infografis dan poster ilmiah.
                </div>
            </div>

            <div class="reveal-node delay-200 glass-card-light rounded-2xl overflow-hidden">
                <button class="faq-toggle w-full p-5 text-left flex justify-between items-center focus:outline-none">
                    <span class="font-semibold text-zinc-900 text-sm sm:text-base">Apakah data dan dokumen saya aman?</span>
                    <span class="faq-icon text-zinc-400 text-xl font-bold transition duration-300">＋</span>
                </button>
                <div class="faq-content hidden px-5 pb-5 text-xs sm:text-sm text-zinc-600 leading-relaxed border-t border-zinc-100 pt-3">
                    Kerahasiaan dokumen Anda adalah prioritas utama. Seluruh materi hanya digunakan murni untuk proses penyelesaian layanan dan tidak dipublikasikan ke pihak luar.
                </div>
            </div>

            <div class="reveal-node delay-300 glass-card-light rounded-2xl overflow-hidden">
                <button class="faq-toggle w-full p-5 text-left flex justify-between items-center focus:outline-none">
                    <span class="font-semibold text-zinc-900 text-sm sm:text-base">Berapa lama estimasi pengerjaan rata-rata?</span>
                    <span class="faq-icon text-zinc-400 text-xl font-bold transition duration-300">＋</span>
                </button>
                <div class="faq-content hidden px-5 pb-5 text-xs sm:text-sm text-zinc-600 leading-relaxed border-t border-zinc-100 pt-3">
                    Olah data dan editing dokumen rata-rata 2–4 hari kerja. Pengembangan aplikasi berkisar antara 1–3 minggu sesuai kebutuhan fitur. Tersedia jalur kilat untuk tenggat mepet.
                </div>
            </div>
        </div>
    </section>

    <!-- CTA SECTION (Dramatic Entry) -->
    <section id="cta" class="py-16 max-w-6xl mx-auto px-6 relative z-10">
        <div class="reveal-node rounded-[36px] bg-gradient-to-tr from-zinc-900 via-zinc-950 to-black p-8 sm:p-14 text-center text-white relative overflow-hidden shadow-2xl">
            <div class="absolute -bottom-24 left-1/2 -translate-x-1/2 w-96 h-96 bg-blue-600/30 blur-3xl rounded-full pointer-events-none"></div>

            <span class="text-xs font-bold text-blue-400 tracking-wider uppercase">Siap Melangkah Lebih Jauh?</span>
            <h2 class="text-3xl sm:text-5xl font-extrabold tracking-tight mt-1 text-white">
                Mulai Konsultasi Proyek Anda Hari Ini.
            </h2>
            <p class="text-zinc-400 text-xs sm:text-sm max-w-lg mx-auto mt-3 leading-relaxed">
                Ceritakan judul tugas akhir atau rencana aplikasi yang ingin Anda bangun. Tim kami siap memberikan estimasi waktu dan solusi terbaik.
            </p>

            <div class="mt-8 flex items-center justify-center">
                <a href="https://api.whatsapp.com/send?phone=6282268925885&text=Halo%20Admin%20QIEVRA+,%20saya%20ingin%20konsultasi%20layanan%20sekarang."
                   target="_blank"
                   class="bg-[#0071e3] text-white px-9 py-3.5 rounded-full text-xs font-bold hover:bg-blue-600 transition shadow-lg shadow-blue-500/30 active:scale-95 flex items-center space-x-2">
                    <span>Chat Tim Kami di WhatsApp</span>
                    <span>→</span>
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="reveal-node border-t border-zinc-200/80 bg-white text-zinc-500 text-xs py-8 relative z-10">
        <div class="max-w-6xl mx-auto px-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p>© {{ date('Y') }} Qievra Plus. Seluruh hak cipta dilindungi undang-undang.</p>
            <div class="flex space-x-6 text-xs text-zinc-400">
                <a href="#hero" class="hover:text-zinc-900 transition">Kembali ke Atas ↑</a>
            </div>
        </div>
    </footer>

    <!-- INTERACTIVE SCRIPTS -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // 0. SCROLL REVEAL (IntersectionObserver System)
            const revealNodes = document.querySelectorAll('.reveal-node');
            const observerOptions = {
                root: null,
                threshold: 0.12,
                rootMargin: '0px 0px -40px 0px'
            };

            const revealObserver = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        obs.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            function initScrollReveal() {
                revealNodes.forEach(node => revealObserver.observe(node));
            }

            // 1. OPENING SCREEN: Vertical Downward Roll Animation
            const preloader = document.getElementById('intro-preloader');
            const greetingText = document.getElementById('greeting-text');

            const greetings = [
                { text: "Halo", delay: 600 },       // Indonesia
                { text: "Hello", delay: 480 },      // Inggris
                { text: "Bonjour", delay: 380 },    // Prancis
                { text: "Hola", delay: 280 },       // Spanyol
                { text: "Ciao", delay: 200 },       // Italia
                { text: "Konnichiwa", delay: 150 }, // Jepang
                { text: "Olá", delay: 110 },        // Portugis
                { text: "Nǐ hǎo", delay: 85 },      // Mandarin
                { text: "Anyoung", delay: 70 },     // Korea
                { text: "QIEVRA+", delay: 650 }     // Reveal Brand Akhir
            ];

            let index = 0;
            function runGreetingSequence() {
                if (index < greetings.length) {
                    const current = greetings[index];

                    greetingText.classList.remove('slide-down-in', 'slide-down-ready');
                    greetingText.classList.add('slide-down-out');

                    setTimeout(() => {
                        greetingText.textContent = current.text;
                        greetingText.classList.remove('slide-down-out');
                        greetingText.classList.add('slide-down-ready');

                        requestAnimationFrame(() => {
                            setTimeout(() => {
                                greetingText.classList.remove('slide-down-ready');
                                greetingText.classList.add('slide-down-in');
                            }, 20);
                        });
                    }, 110);

                    index++;
                    setTimeout(runGreetingSequence, current.delay);
                } else {
                    // Selesai: Preloader slide up & trigger komponen hero
                    setTimeout(() => {
                        if (preloader) {
                            preloader.classList.add('hide-intro');
                        }
                        // Pemicu animasi elemen pertama di layar
                        setTimeout(() => {
                            initScrollReveal();
                        }, 200);
                    }, 350);
                }
            }

            runGreetingSequence();

            // 2. Mobile Menu Toggle
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

                mobileMenu.querySelectorAll('.mobile-nav-link').forEach(link => {
                    link.addEventListener('click', () => {
                        mobileMenu.classList.remove('menu-open');
                        mobileMenu.classList.add('menu-closed');
                        hamburgerIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>`;
                        hamburgerIcon.style.transform = 'rotate(0deg)';
                    });
                });
            }

            // 3. FAQ Accordion Single Open
            const faqToggles = document.querySelectorAll('.faq-toggle');
            faqToggles.forEach(toggle => {
                toggle.addEventListener('click', () => {
                    const content = toggle.nextElementSibling;
                    const icon = toggle.querySelector('.faq-icon');
                    const isHidden = content.classList.contains('hidden');

                    document.querySelectorAll('.faq-content').forEach(c => c.classList.add('hidden'));
                    document.querySelectorAll('.faq-icon').forEach(i => {
                        i.textContent = '＋';
                        i.style.transform = 'rotate(0deg)';
                    });

                    if (isHidden) {
                        content.classList.remove('hidden');
                        icon.textContent = '✕';
                        icon.style.transform = 'rotate(90deg)';
                    }
                });
            });

            // 4. Carousel Slider System
            const slides = document.querySelectorAll('.slide-element');
            const dots = document.querySelectorAll('.slider-dot');
            const btnPrev = document.getElementById('prev-slide');
            const btnNext = document.getElementById('next-slide');
            const sliderBox = document.getElementById('slider-box');
            const progressBar = document.getElementById('slide-progress');

            let currentSlide = 0;
            const totalSlides = slides.length;
            const slideIntervalTime = 4000;
            let slideTimer = null;

            function resetProgress() {
                if (progressBar) {
                    progressBar.style.transition = 'none';
                    progressBar.style.width = '0%';
                    setTimeout(() => {
                        progressBar.style.transition = 'width 4000ms linear';
                        progressBar.style.width = '100%';
                    }, 50);
                }
            }

            function showSlide(index) {
                if (totalSlides === 0) return;

                if (index >= totalSlides) {
                    currentSlide = 0;
                } else if (index < 0) {
                    currentSlide = totalSlides - 1;
                } else {
                    currentSlide = index;
                }

                slides.forEach((slide, idx) => {
                    if (idx === currentSlide) {
                        slide.classList.remove('opacity-0', 'pointer-events-none', 'translate-x-full', '-translate-x-full');
                        slide.classList.add('opacity-100', 'translate-x-0');
                    } else if (idx < currentSlide) {
                        slide.classList.remove('opacity-100', 'translate-x-0');
                        slide.classList.add('opacity-0', 'pointer-events-none', '-translate-x-full');
                    } else {
                        slide.classList.remove('opacity-100', 'translate-x-0');
                        slide.classList.add('opacity-0', 'pointer-events-none', 'translate-x-full');
                    }
                });

                dots.forEach((dot, idx) => {
                    if (idx === currentSlide) {
                        dot.classList.remove('bg-white/30', 'w-2');
                        dot.classList.add('bg-blue-500', 'w-6');
                    } else {
                        dot.classList.remove('bg-blue-500', 'w-6');
                        dot.classList.add('bg-white/30', 'w-2');
                    }
                });

                resetProgress();
            }

            function nextSlide() {
                showSlide(currentSlide + 1);
            }

            function prevSlide() {
                showSlide(currentSlide - 1);
            }

            function startAutoPlay() {
                stopAutoPlay();
                if (totalSlides > 1) {
                    slideTimer = setInterval(nextSlide, slideIntervalTime);
                    resetProgress();
                }
            }

            function stopAutoPlay() {
                if (slideTimer) {
                    clearInterval(slideTimer);
                    slideTimer = null;
                }
                if (progressBar) {
                    progressBar.style.width = '0%';
                }
            }

            if (btnNext) {
                btnNext.addEventListener('click', () => {
                    nextSlide();
                    startAutoPlay();
                });
            }

            if (btnPrev) {
                btnPrev.addEventListener('click', () => {
                    prevSlide();
                    startAutoPlay();
                });
            }

            dots.forEach(dot => {
                dot.addEventListener('click', () => {
                    const targetIdx = parseInt(dot.getAttribute('data-slide'), 10);
                    showSlide(targetIdx);
                    startAutoPlay();
                });
            });

            if (sliderBox) {
                sliderBox.addEventListener('mouseenter', stopAutoPlay);
                sliderBox.addEventListener('mouseleave', startAutoPlay);
            }

            showSlide(0);
            startAutoPlay();

            // 5. Sticky Navbar Dynamic Shadow
            const mainNav = document.getElementById('main-nav');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 20) {
                    mainNav.classList.add('shadow-sm', 'bg-white/95');
                } else {
                    mainNav.classList.remove('shadow-sm', 'bg-white/95');
                }
            }, { passive: true });
        });
    </script>
</body>
</html>

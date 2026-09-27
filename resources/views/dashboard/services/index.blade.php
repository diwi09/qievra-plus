@extends('dashboard.layouts.app')

@section('title', 'Katalog Layanan')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-6 border-b border-zinc-200/70">
        <div>
            <span class="text-xs font-semibold text-blue-600 uppercase tracking-widest font-mono">Sinkronisasi Front-End</span>
            <h1 class="text-3xl font-extrabold text-[#1d1d1f] tracking-tight mt-0.5">Katalog Layanan Slider</h1>
            <p class="text-xs sm:text-sm text-zinc-500 mt-1">
                Data di sini disinkronkan langsung ke slider halaman depan (welcome page).
            </p>
        </div>
        <a href="{{ route('dashboard.services.create') }}"
           class="inline-flex items-center gap-2 bg-[#0071e3] text-white px-5 py-2.5 rounded-full text-xs font-semibold hover:bg-[#0077ed] shadow-[0_4px_12px_rgba(0,113,227,0.25)] transition active:scale-95 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Layanan Baru</span>
        </a>
    </div>

    @if (session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Cards Grid Layanan -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @forelse ($services as $service)
            <div class="group relative rounded-3xl bg-white/80 backdrop-blur-xl border border-zinc-200/70 p-5 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] transition flex flex-col justify-between overflow-hidden">
                <div class="space-y-3">
                    <div class="relative h-44 rounded-2xl overflow-hidden bg-zinc-950">
                        <img src="{{ $service->image_url }}" alt="{{ $service->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>

                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider
                                {{ $service->badge_color === 'purple' ? 'bg-purple-500/30 text-purple-200 border border-purple-400/30' : '' }}
                                {{ $service->badge_color === 'emerald' ? 'bg-emerald-500/30 text-emerald-200 border border-emerald-400/30' : '' }}
                                {{ $service->badge_color === 'amber' ? 'bg-amber-500/30 text-amber-200 border border-amber-400/30' : '' }}
                                {{ $service->badge_color === 'blue' ? 'bg-blue-500/30 text-blue-200 border border-blue-400/30' : '' }}">
                                {{ $service->badge }}
                            </span>
                        </div>

                        <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white text-[11px] font-mono">
                            <span>Posisi Slide: #{{ $service->order_position }}</span>
                            <span class="inline-flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full {{ $service->is_active ? 'bg-emerald-400' : 'bg-zinc-400' }}"></span>
                                {{ $service->is_active ? 'Tayang di Web' : 'Disembunyikan' }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-base font-bold text-zinc-900 leading-snug">{{ $service->title }}</h3>
                        <p class="text-xs text-zinc-500 mt-1 line-clamp-2 leading-relaxed">{{ $service->description }}</p>
                    </div>
                </div>

                <div class="pt-4 mt-4 border-t border-zinc-100 flex items-center justify-between">
                    <span class="text-[11px] font-mono text-zinc-400">Warna Aksen: {{ ucfirst($service->badge_color) }}</span>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('dashboard.services.edit', $service) }}"
                           class="px-3.5 py-1.5 rounded-full bg-zinc-100 hover:bg-[#0071e3] hover:text-white text-zinc-700 text-xs font-semibold transition active:scale-95">
                            Edit Slide
                        </a>
                        <form action="{{ route('dashboard.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Hapus layanan ini dari website?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 rounded-full text-zinc-400 hover:text-red-600 hover:bg-red-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-2 py-16 text-center bg-white rounded-3xl border border-zinc-200/70">
                <p class="text-xs text-zinc-400">Belum ada katalog layanan. Silakan buat layanan baru.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection

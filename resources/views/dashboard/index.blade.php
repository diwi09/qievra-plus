@extends('dashboard.layouts.app')

@section('title', 'Pesanan Masuk & Berkas')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto">

    <!-- Top Header: Apple Studio Style (Konsisten dengan Overview) -->
    <section class="flex flex-col md:flex-row md:items-end justify-between gap-5 pb-6 border-b border-zinc-200/60">
        <div class="space-y-1.5">
            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-blue-50/80 border border-blue-100 text-[11px] font-semibold text-[#0071e3] tracking-wide">
                <span class="w-1.5 h-1.5 rounded-full bg-[#0071e3] animate-pulse"></span>
                Manajemen Berkas & Naskah
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-[#1d1d1f]">
                Pesanan & Berkas Masuk
            </h1>
            <p class="text-sm text-zinc-500 font-normal">
                Kelola seluruh alur pesanan naskah akademik mahasiswa, verifikasi pembayaran, dan serahkan berkas hasil akhir.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full bg-white text-zinc-700 hover:text-zinc-950 text-xs font-semibold border border-zinc-200/80 shadow-[0_1px_2px_rgba(0,0,0,0.04)] hover:border-zinc-300 transition-all duration-200 active:scale-95">
                <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>Ringkasan Kerja</span>
            </a>
            <span class="px-4 py-2.5 rounded-full bg-zinc-100 text-zinc-800 text-xs font-bold font-mono border border-zinc-200/60">
                Total: {{ $metrics['total'] ?? 0 }} Order
            </span>
        </div>
    </section>

    <!-- 4 Apple Metric Cards Status Filter -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Metric 1: Semua -->
        <a href="{{ route('dashboard.orders.index') }}"
           class="group relative p-6 rounded-3xl bg-white/80 backdrop-blur-xl border {{ !request('status') || request('status') === 'all' ? 'border-zinc-900 ring-2 ring-zinc-900/5' : 'border-zinc-200/70' }} shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] hover:-translate-y-0.5 transition-all duration-300">
            <div class="flex items-center justify-between text-zinc-400 mb-3">
                <span class="text-xs font-medium tracking-wide">Semua Berkas</span>
                <div class="w-7 h-7 rounded-full bg-zinc-100 flex items-center justify-center text-zinc-600">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-[#1d1d1f] tracking-tight">{{ $metrics['total'] ?? 0 }}</div>
            <p class="text-[11px] text-zinc-400 mt-1 font-medium">Keseluruhan order klien</p>
        </a>

        <!-- Metric 2: Diproses -->
        <a href="{{ route('dashboard.orders.index', ['status' => 'Diproses']) }}"
           class="group relative p-6 rounded-3xl bg-white/80 backdrop-blur-xl border {{ request('status') === 'Diproses' ? 'border-[#0071e3] ring-2 ring-blue-500/10' : 'border-zinc-200/70' }} shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] hover:-translate-y-0.5 transition-all duration-300">
            <div class="flex items-center justify-between text-blue-500 mb-3">
                <span class="text-xs font-medium tracking-wide text-zinc-500">Sedang Diproses</span>
                <div class="w-7 h-7 rounded-full bg-blue-50 flex items-center justify-center text-[#0071e3]">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-[#0071e3] tracking-tight">{{ $metrics['in_progress'] ?? 0 }}</div>
            <p class="text-[11px] text-zinc-400 mt-1 font-medium">Antrean pengerjaan tim</p>
        </a>

        <!-- Metric 3: Revisi -->
        <a href="{{ route('dashboard.orders.index', ['status' => 'Revisi']) }}"
           class="group relative p-6 rounded-3xl bg-white/80 backdrop-blur-xl border {{ request('status') === 'Revisi' ? 'border-amber-500 ring-2 ring-amber-500/10' : 'border-zinc-200/70' }} shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] hover:-translate-y-0.5 transition-all duration-300">
            <div class="flex items-center justify-between text-amber-500 mb-3">
                <span class="text-xs font-medium tracking-wide text-zinc-500">Perlu Revisi</span>
                <div class="w-7 h-7 rounded-full bg-amber-50 flex items-center justify-center text-amber-600">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-amber-600 tracking-tight">{{ $metrics['revision'] ?? 0 }}</div>
            <p class="text-[11px] text-zinc-400 mt-1 font-medium">Masukan & perbaikan klien</p>
        </a>

        <!-- Metric 4: Selesai -->
        <a href="{{ route('dashboard.orders.index', ['status' => 'Selesai']) }}"
           class="group relative p-6 rounded-3xl bg-white/80 backdrop-blur-xl border {{ request('status') === 'Selesai' ? 'border-emerald-500 ring-2 ring-emerald-500/10' : 'border-zinc-200/70' }} shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] hover:-translate-y-0.5 transition-all duration-300">
            <div class="flex items-center justify-between text-emerald-500 mb-3">
                <span class="text-xs font-medium tracking-wide text-zinc-500">Tuntas Selesai</span>
                <div class="w-7 h-7 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-emerald-600 tracking-tight">{{ $metrics['completed'] ?? 0 }}</div>
            <p class="text-[11px] text-zinc-400 mt-1 font-medium">Telah diserahkan ke klien</p>
        </a>
    </section>

    <!-- Interactive Apple Toolbar: Search & Dynamic Filter -->
    <section class="bg-white/80 backdrop-blur-xl p-4 sm:p-5 rounded-[24px] border border-zinc-200/70 shadow-[0_4px_20px_rgba(0,0,0,0.02)]">
        <form method="GET" action="{{ route('dashboard.orders.index') }}" class="flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="relative w-full sm:w-80">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-zinc-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode order, nama mahasiswa, kampus..."
                       class="w-full pl-10 pr-4 py-2 rounded-xl border border-zinc-200 text-xs font-medium focus:ring-2 focus:ring-[#0071e3] focus:border-transparent focus:outline-none bg-zinc-50/60 placeholder-zinc-400 transition">
            </div>

            <div class="w-full sm:w-auto flex items-center gap-2.5">
                <select name="status" onchange="this.form.submit()"
                        class="w-full sm:w-44 px-3.5 py-2 rounded-xl border border-zinc-200 text-xs font-semibold focus:ring-2 focus:ring-[#0071e3] focus:outline-none bg-zinc-50/60 text-zinc-700 transition">
                    <option value="all" {{ !request('status') || request('status') === 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Diproses" {{ request('status') === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Revisi" {{ request('status') === 'Revisi' ? 'selected' : '' }}>Revisi</option>
                    <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>

                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('dashboard.orders.index') }}"
                       class="px-4 py-2 rounded-xl text-xs font-semibold text-zinc-500 hover:text-zinc-950 hover:bg-zinc-100 transition duration-150">
                        Reset Filter
                    </a>
                @endif
            </div>
        </form>
    </section>

    <!-- Orders Table: Clean Apple Minimalist Studio -->
    <section class="bg-white/80 backdrop-blur-xl rounded-[28px] border border-zinc-200/70 shadow-[0_4px_24px_rgba(0,0,0,0.02)] overflow-hidden">
        <!-- Table Header -->
        <div class="px-7 py-5 border-b border-zinc-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-bold text-base text-[#1d1d1f] tracking-tight">Daftar Rekapitulasi Berkas</h2>
                <p class="text-xs text-zinc-400 font-normal">Antrean berkas mahasiswa yang butuh tinjauan, pengerjaan, dan tindak lanjut</p>
            </div>
            <span class="text-xs font-semibold text-zinc-400 font-mono">
                Menampilkan {{ method_exists($orders, 'count') ? $orders->count() : count($orders ?? []) }} berkas
            </span>
        </div>

        <!-- Table View -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-zinc-100 bg-zinc-50/50 text-zinc-400 uppercase font-semibold text-[10px] tracking-wider">
                        <th class="py-3.5 px-6">ID Berkas</th>
                        <th class="py-3.5 px-6">Mahasiswa & Institusi</th>
                        <th class="py-3.5 px-6">Kategori Layanan</th>
                        <th class="py-3.5 px-6">Biaya Proyek</th>
                        <th class="py-3.5 px-6">Status Pengerjaan</th>
                        <th class="py-3.5 px-6 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100/70 font-medium text-zinc-600">
                    @forelse ($orders ?? [] as $item)
                        @php
                            $order = is_array($item) ? (object) $item : $item;
                            $serviceTitle = is_object($order->service ?? null)
                                ? ($order->service->title ?? '-')
                                : (is_array($order->service ?? null) ? ($order->service['title'] ?? '-') : ($order->service ?? 'Layanan Akademik'));
                            $orderCode = $order->order_code ?? ($order->id ? 'ORD-' . $order->id : '-');
                            $clientName = $order->client_name ?? ($order->client ?? '-');
                            $clientCampus = $order->client_campus ?? ($order->campus ?? '-');
                            $price = $order->price ?? 0;
                            $status = $order->status ?? 'Pending';
                        @endphp
                        <tr class="hover:bg-zinc-50/60 transition duration-150 group">
                            <!-- Code -->
                            <td class="py-4 px-6 font-mono font-bold text-zinc-900">
                                <span class="px-2 py-1 rounded-lg bg-zinc-100 text-zinc-700 text-[11px] group-hover:bg-white group-hover:border group-hover:border-zinc-200 transition">
                                    {{ $orderCode }}
                                </span>
                            </td>

                            <!-- Client & Campus -->
                            <td class="py-4 px-6">
                                <div class="font-bold text-zinc-900 leading-tight">{{ $clientName }}</div>
                                <div class="text-[11px] text-zinc-400 mt-0.5">{{ $clientCampus }}</div>
                            </td>

                            <!-- Service -->
                            <td class="py-4 px-6 text-zinc-700 font-medium">
                                {{ $serviceTitle }}
                            </td>

                            <!-- Price -->
                            <td class="py-4 px-6 font-mono font-bold text-zinc-900">
                                Rp {{ number_format($price, 0, ',', '.') }}
                            </td>

                            <!-- Status Pill (Apple Style) -->
                            <td class="py-4 px-6">
                                @if ($status === 'Selesai')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Selesai
                                    </span>
                                @elseif (in_array($status, ['Diproses', 'Proses']))
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-blue-50 text-[#0071e3] border border-blue-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#0071e3] animate-pulse"></span>
                                        Diproses
                                    </span>
                                @elseif ($status === 'Revisi')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200/60">
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

                            <!-- Action Button -->
                            <td class="py-4 px-6 text-right">
                                <a href="{{ isset($order->id) && is_numeric($order->id) ? route('dashboard.orders.show', $order->id) : '#' }}"
                                   class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-full bg-zinc-100 hover:bg-[#0071e3] hover:text-white text-zinc-800 text-xs font-semibold transition-all duration-150 active:scale-95 shadow-sm">
                                    <span>Detail & Berkas</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-14 text-center">
                                <div class="w-10 h-10 rounded-full bg-zinc-100 flex items-center justify-center mx-auto text-zinc-400 mb-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                </div>
                                <div class="text-xs font-semibold text-zinc-700">Belum ada pesanan yang sesuai</div>
                                <div class="text-[11px] text-zinc-400 mt-0.5">Semua data berkas yang diajukan mahasiswa akan tampil di sini.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($orders) && method_exists($orders, 'hasPages') && $orders->hasPages())
            <div class="p-4 border-t border-zinc-100">
                {{ $orders->links() }}
            </div>
        @endif
    </section>

</div>
@endsection

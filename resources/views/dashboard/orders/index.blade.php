@extends('dashboard.layouts.app')

@section('title', 'Pesanan & Berkas')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-6 border-b border-zinc-200/70">
        <div>
            <span class="text-xs font-semibold text-blue-600 uppercase tracking-widest font-mono">Manajemen Proyek</span>
            <h1 class="text-3xl font-extrabold text-[#1d1d1f] tracking-tight mt-0.5">Pesanan Masuk & Berkas</h1>
            <p class="text-xs sm:text-sm text-zinc-500 mt-1">
                Kelola antrean naskah akademik, pantau status pengerjaan, dan unggah berkas hasil ke mahasiswa.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3.5 py-1.5 rounded-full bg-zinc-100 text-zinc-700 text-xs font-mono font-semibold">
                Total: {{ $metrics['total'] ?? 0 }} Order
            </span>
        </div>
    </div>

    @if (session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Mini Cards Status -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <a href="{{ route('dashboard.orders.index') }}"
           class="p-4 rounded-2xl bg-white border border-zinc-200/70 hover:border-zinc-300 transition shadow-sm">
            <span class="text-[11px] text-zinc-400 font-semibold uppercase tracking-wider">Semua Pesanan</span>
            <div class="text-2xl font-extrabold text-zinc-900 mt-1">{{ $metrics['total'] ?? 0 }}</div>
        </a>
        <a href="{{ route('dashboard.orders.index', ['status' => 'Diproses']) }}"
           class="p-4 rounded-2xl bg-blue-50/50 border border-blue-100 hover:border-blue-200 transition shadow-sm">
            <span class="text-[11px] text-blue-600 font-semibold uppercase tracking-wider">Diproses</span>
            <div class="text-2xl font-extrabold text-[#0071e3] mt-1">{{ $metrics['in_progress'] ?? 0 }}</div>
        </a>
        <a href="{{ route('dashboard.orders.index', ['status' => 'Revisi']) }}"
           class="p-4 rounded-2xl bg-amber-50/50 border border-amber-100 hover:border-amber-200 transition shadow-sm">
            <span class="text-[11px] text-amber-600 font-semibold uppercase tracking-wider">Revisi Klien</span>
            <div class="text-2xl font-extrabold text-amber-700 mt-1">{{ $metrics['revision'] ?? 0 }}</div>
        </a>
        <a href="{{ route('dashboard.orders.index', ['status' => 'Selesai']) }}"
           class="p-4 rounded-2xl bg-emerald-50/50 border border-emerald-100 hover:border-emerald-200 transition shadow-sm">
            <span class="text-[11px] text-emerald-600 font-semibold uppercase tracking-wider">Tuntas</span>
            <div class="text-2xl font-extrabold text-emerald-700 mt-1">{{ $metrics['completed'] ?? 0 }}</div>
        </a>
    </div>

    <!-- Toolbar: Search & Filter -->
    <div class="bg-white p-4 rounded-2xl border border-zinc-200/70 shadow-sm flex flex-col sm:flex-row gap-3 items-center justify-between">
        <form method="GET" action="{{ route('dashboard.orders.index') }}" class="w-full flex flex-col sm:flex-row gap-3 items-center">
            <div class="relative w-full sm:w-80">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode, nama, kampus..."
                       class="w-full pl-9 pr-4 py-2 rounded-xl border border-zinc-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none bg-zinc-50/50">
            </div>

            <div class="w-full sm:w-auto flex items-center gap-2">
                <select name="status" onchange="this.form.submit()" class="w-full sm:w-44 px-3 py-2 rounded-xl border border-zinc-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none bg-zinc-50/50 font-medium">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Revisi" {{ request('status') == 'Revisi' ? 'selected' : '' }}>Revisi</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>

                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('dashboard.orders.index') }}" class="px-3 py-2 text-xs font-semibold text-zinc-500 hover:text-zinc-900 transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-3xl border border-zinc-200/70 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-zinc-100 bg-zinc-50/50 text-zinc-400 uppercase font-semibold text-[10px] tracking-wider">
                        <th class="py-3.5 px-6">Kode Order</th>
                        <th class="py-3.5 px-6">Mahasiswa & Institusi</th>
                        <th class="py-3.5 px-6">Layanan</th>
                        <th class="py-3.5 px-6">Biaya Proyek</th>
                        <th class="py-3.5 px-6">Status Pengerjaan</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 font-medium text-zinc-600">
                    @forelse ($orders as $order)
                        @php
                            $orderCode = $order->order_code ?? ('ORD-' . $order->id);
                            $serviceTitle = $order->service->title ?? ($order->service_title ?? 'Bimbingan Akademik');
                        @endphp
                        <tr class="hover:bg-zinc-50/70 transition duration-150 group">
                            <td class="py-4 px-6 font-mono font-bold text-zinc-900">
                                <span class="px-2 py-1 rounded-lg bg-zinc-100 text-zinc-700 text-[11px] group-hover:bg-white group-hover:border group-hover:border-zinc-200 transition">
                                    {{ $orderCode }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-zinc-900 leading-tight">{{ $order->client_name ?? '-' }}</div>
                                <div class="text-[11px] text-zinc-400 mt-0.5">{{ $order->client_campus ?? '-' }}</div>
                            </td>
                            <td class="py-4 px-6 text-zinc-700">
                                {{ $serviceTitle }}
                            </td>
                            <td class="py-4 px-6 font-mono font-bold text-zinc-900">
                                Rp {{ number_format($order->price ?? 0, 0, ',', '.') }}
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
                                <a href="{{ route('dashboard.orders.show', $order->id) }}"
                                   class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-full bg-zinc-100 hover:bg-[#0071e3] hover:text-white text-zinc-800 text-xs font-semibold transition shadow-sm active:scale-95">
                                    <span>Detail / Berkas</span>
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
                                <div class="text-xs font-semibold text-zinc-700">Belum ada pesanan aktif</div>
                                <div class="text-[11px] text-zinc-400 mt-0.5">Semua berkas dan order masuk akan tersaji di sini.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($orders, 'hasPages') && $orders->hasPages())
            <div class="p-4 border-t border-zinc-100">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

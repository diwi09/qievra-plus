@extends('dashboard.layouts.app')

@section('title', 'Detail Order ' . ($order->order_code ?? $order->id))

@section('content')
@php
    // Normalisasi nomor HP untuk URL wa.me (contoh: 0812... -> 62812...)
    $rawPhone = $order->client_whatsapp ?? ($order->client_phone ?? '');
    $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
    if (str_starts_with($cleanPhone, '0')) {
        $cleanPhone = '62' . substr($cleanPhone, 1);
    }
@endphp

<div class="max-w-5xl mx-auto space-y-8">

    <!-- Top Breadcrumb & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-zinc-200/70">
        <div>
            <a href="{{ route('dashboard.orders.index') }}" class="text-xs font-semibold text-[#0071e3] hover:underline flex items-center gap-1">
                <span>← Kembali ke Daftar Pesanan</span>
            </a>
            <div class="flex items-center gap-3 mt-1.5">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1d1d1f] tracking-tight">
                    Order {{ $order->order_code ?? 'ORD-'.$order->id }}
                </h1>
                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold
                    {{ $order->status === 'Selesai' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : '' }}
                    {{ in_array($order->status, ['Diproses', 'Proses']) ? 'bg-blue-50 text-[#0071e3] border border-blue-200' : '' }}
                    {{ $order->status === 'Revisi' ? 'bg-amber-50 text-amber-700 border border-amber-200' : '' }}
                    {{ $order->status === 'Pending' ? 'bg-zinc-100 text-zinc-600 border border-zinc-200' : '' }}">
                    {{ $order->status }}
                </span>
            </div>
        </div>

        <form action="{{ route('dashboard.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Hapus permanen pesanan ini beserta semua berkas terkait?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 rounded-full border border-red-200 text-red-600 hover:bg-red-50 text-xs font-semibold transition active:scale-95">
                Hapus Pesanan
            </button>
        </form>
    </div>

    @if (session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- KIRI: Rincian Mahasiswa & Layanan (2 Kolom) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Info Mahasiswa -->
            <div class="bg-white/80 backdrop-blur-xl p-6 rounded-3xl border border-zinc-200/70 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-zinc-900 border-b border-zinc-100 pb-3">Informasi Mahasiswa / Klien</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-zinc-400 block font-medium">Nama Lengkap</span>
                        <span class="font-bold text-zinc-900 text-sm">{{ $order->client_name }}</span>
                    </div>
                    <div>
                        <span class="text-zinc-400 block font-medium">Asal Universitas / Kampus</span>
                        <span class="font-bold text-zinc-900 text-sm">{{ $order->client_campus ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-zinc-400 block font-medium">Kontak WhatsApp Klien</span>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="font-bold text-zinc-900 text-sm font-mono">{{ $rawPhone ?: '-' }}</span>
                            @if ($cleanPhone)
                                <a href="https://wa.me/{{ $cleanPhone }}?text=Halo%20{{ urlencode($order->client_name) }},%20saya%20Admin%20AKSARA+%20terkait%20pesanan%20{{ $order->order_code }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-[#25D366] text-white text-[10px] font-bold hover:bg-[#20bd5a] transition shadow-sm active:scale-95">
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                    <span>Chat WA</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div>
                        <span class="text-zinc-400 block font-medium">Tanggal Pengajuan</span>
                        <span class="font-semibold text-zinc-800">{{ $order->created_at ? $order->created_at->translatedFormat('d F Y, H:i') : '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Detail Naskah & Proyek -->
            <div class="bg-white/80 backdrop-blur-xl p-6 rounded-3xl border border-zinc-200/70 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-zinc-900 border-b border-zinc-100 pb-3">Spesifikasi Proyek</h3>
                <div class="space-y-4 text-xs">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 p-4 rounded-2xl bg-zinc-50 border border-zinc-100">
                        <div>
                            <span class="text-zinc-400 block font-medium">Layanan yang Dipilih</span>
                            <span class="font-bold text-zinc-900 text-sm mt-0.5 inline-block">
                                {{ $order->service->title ?? ($order->service_title ?? 'Layanan Akademik') }}
                            </span>
                        </div>
                        <div class="sm:text-right">
                            <span class="text-zinc-400 block font-medium">Biaya Saat Ini</span>
                            <span class="font-mono font-extrabold text-sm text-zinc-900">
                                @if($order->price > 0)
                                    Rp {{ number_format($order->price, 0, ',', '.') }}
                                @else
                                    <span class="text-amber-600 font-semibold">Belum Ditetapkan</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <div>
                        <span class="text-zinc-400 block font-medium">Catatan / Kebutuhan Klien</span>
                        <p class="mt-1 p-3.5 rounded-2xl bg-zinc-50 border border-zinc-100 text-zinc-700 leading-relaxed font-normal">
                            {{ $order->notes ?? 'Tidak ada catatan khusus yang dilampirkan oleh klien.' }}
                        </p>
                    </div>

                    @if ($order->client_file_path)
                        <div class="pt-2">
                            <span class="text-zinc-400 block font-medium mb-1.5">Berkas Mentah dari Klien</span>
                            <a href="{{ Storage::url($order->client_file_path) }}" target="_blank" download
                               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-[#0071e3] font-semibold text-xs transition border border-blue-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span>Unduh Berkas Mentah Klien</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- KANAN: Form Proses Status, Harga & Upload Berkas (1 Kolom) -->
        <div class="space-y-6">
            <form action="{{ route('dashboard.orders.update', $order) }}" method="POST" enctype="multipart/form-data"
                  class="bg-white/80 backdrop-blur-xl p-6 rounded-3xl border border-zinc-200/70 shadow-sm space-y-4">
                @csrf
                @method('PUT')

                <h3 class="text-sm font-bold text-zinc-900 border-b border-zinc-100 pb-3">Tindak Lanjut & Penetapan</h3>

                <!-- Update Status -->
                <div>
                    <label class="block text-xs font-bold text-zinc-700 mb-1.5">Ubah Status Pengerjaan</label>
                    <select name="status" class="w-full px-3.5 py-2.5 rounded-xl border border-zinc-200 text-xs font-semibold focus:ring-2 focus:ring-blue-500 focus:outline-none bg-zinc-50">
                        <option value="Pending" {{ $order->status === 'Pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                        <option value="Diproses" {{ in_array($order->status, ['Diproses', 'Proses']) ? 'selected' : '' }}>Diproses (Sedang Dikerjakan)</option>
                        <option value="Revisi" {{ $order->status === 'Revisi' ? 'selected' : '' }}>Revisi (Perlu Perbaikan)</option>
                        <option value="Selesai" {{ $order->status === 'Selesai' ? 'selected' : '' }}>Selesai (Tuntas)</option>
                    </select>
                </div>

                <!-- Input Harga / Biaya Layanan -->
                <div>
                    <label class="block text-xs font-bold text-zinc-700 mb-1.5">Penetapan Biaya Layanan (Rp)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-bold text-zinc-400">Rp</span>
                        <input type="number" name="price" value="{{ old('price', $order->price ?? 0) }}" min="0" step="1000"
                               placeholder="Contoh: 150000"
                               class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-zinc-200 text-xs font-mono font-bold focus:ring-2 focus:ring-blue-500 focus:outline-none bg-zinc-50">
                    </div>
                    <span class="text-[10px] text-zinc-400 block mt-1">Biaya ini akan langsung muncul di halaman tracking klien.</span>
                </div>

                <!-- Catatan Admin untuk Klien -->
                <div>
                    <label class="block text-xs font-bold text-zinc-700 mb-1.5">Catatan Tim untuk Klien</label>
                    <textarea name="admin_note" rows="3" placeholder="Tulis arahan revisi atau detail hasil pekerjaan..."
                              class="w-full px-3.5 py-2.5 rounded-xl border border-zinc-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none bg-zinc-50 leading-relaxed">{{ old('admin_note', $order->admin_note ?? '') }}</textarea>
                </div>

                <!-- Upload File Berkas Hasil -->
                <div>
                    <label class="block text-xs font-bold text-zinc-700 mb-1.5">Upload Berkas Hasil Pengerjaan</label>
                    <input type="file" name="result_file"
                           class="w-full text-xs text-zinc-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#0071e3] hover:file:bg-blue-100 cursor-pointer">
                    <span class="text-[10px] text-zinc-400 block mt-1">Format: DOC, DOCX, PDF, ZIP (Maksimal 25MB)</span>

                    @if ($order->result_file_path)
                        <div class="mt-3 p-3 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-between">
                            <div class="flex items-center gap-2 truncate max-w-[170px]">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span class="text-[11px] font-semibold text-emerald-800 truncate">Berkas Tersedia</span>
                            </div>
                            <a href="{{ Storage::url($order->result_file_path) }}" target="_blank" download class="text-[11px] font-bold text-[#0071e3] hover:underline">
                                Unduh
                            </a>
                        </div>
                    @endif
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-2.5 rounded-full bg-[#0071e3] hover:bg-[#0077ed] text-white text-xs font-bold transition shadow-sm active:scale-95">
                        Simpan Perubahan & Berkas
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection

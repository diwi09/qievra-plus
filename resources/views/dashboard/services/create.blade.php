@extends('dashboard.layouts.app')

@section('title', 'Tambah Layanan Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="pb-5 border-b border-zinc-200/70">
        <a href="{{ route('dashboard.services.index') }}" class="text-xs font-semibold text-[#0071e3] hover:underline">← Kembali ke Katalog</a>
        <h1 class="text-2xl font-extrabold text-[#1d1d1f] tracking-tight mt-1">Tambah Layanan Baru ke Beranda</h1>
    </div>

    <form action="{{ route('dashboard.services.store') }}" method="POST" class="bg-white p-8 rounded-3xl border border-zinc-200/70 shadow-sm space-y-5">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-zinc-700 mb-1.5">Teks Badge Kategori</label>
                <input type="text" name="badge" value="{{ old('badge', '05 / KONSULTASI RISET') }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-zinc-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-zinc-700 mb-1.5">Warna Aksen Badge & Tombol</label>
                <select name="badge_color" class="w-full px-4 py-2.5 rounded-xl border border-zinc-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="blue">Biru (Olah Data / Analisis)</option>
                    <option value="purple">Ungu (Editing / Plagiasi)</option>
                    <option value="emerald">Hijau Emerald (Sistem / Software)</option>
                    <option value="amber">Amber Gold (Media Visual / Presentasi)</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-zinc-700 mb-1.5">Judul Layanan</label>
            <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Bimbingan Pembuatan Sistem Skripsi" required
                   class="w-full px-4 py-2.5 rounded-xl border border-zinc-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <div>
            <label class="block text-xs font-bold text-zinc-700 mb-1.5">Deskripsi Ringkas</label>
            <textarea name="description" rows="3" required placeholder="Jelaskan ruang lingkup layanan secara padat..."
                      class="w-full px-4 py-2.5 rounded-xl border border-zinc-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-zinc-700 mb-1.5">URL Gambar Latar Slide (Unsplash / CDN)</label>
            <input type="url" name="image_url" value="{{ old('image_url', 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=1600&auto=format&fit=crop') }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-zinc-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center pt-2">
            <div>
                <label class="block text-xs font-bold text-zinc-700 mb-1.5">Nomor Urutan Slide</label>
                <input type="number" name="order_position" value="{{ old('order_position', 5) }}" min="1" required
                       class="w-full px-4 py-2.5 rounded-xl border border-zinc-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div class="sm:pt-5">
                <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-semibold text-zinc-700">
                    <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500">
                    <span>Tampilkan langsung di slider beranda</span>
                </label>
            </div>
        </div>

        <div class="pt-4 border-t border-zinc-100 flex justify-end gap-3">
            <a href="{{ route('dashboard.services.index') }}" class="px-5 py-2.5 rounded-full text-xs font-semibold text-zinc-600 hover:bg-zinc-100 transition">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-full bg-[#0071e3] hover:bg-[#0077ed] text-white text-xs font-semibold shadow-sm transition active:scale-95">
                Simpan & Sinkronkan
            </button>
        </div>
    </form>
</div>
@endsection

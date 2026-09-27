<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Layanan — QIEVRA Plus</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #fafafa; color: #1d1d1f; }
        .glass-panel { background: rgba(255, 255, 255, 0.92); backdrop-filter: blur(20px); border: 1px solid rgba(0,0,0,0.06); }
    </style>
</head>
<body class="antialiased selection:bg-blue-600 selection:text-white min-h-screen py-10 px-4 flex flex-col justify-center">

    <div class="max-w-2xl mx-auto w-full">
        <!-- Brand Header -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 text-xl font-extrabold tracking-wider mb-3">
                <span class="text-[#0B1E48]">QIEVRA</span>
                <span class="text-[#F59E0B] text-2xl font-black -translate-y-0.5">+</span>
            </a>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1d1d1f] tracking-tight">Form Pengajuan Proyek & Berkas</h1>
            <p class="text-xs sm:text-sm text-zinc-500 mt-1">Lengkapi rincian kebutuhan bimbingan atau naskah Anda untuk ditindaklanjuti oleh tim.</p>
        </div>

        <!-- Form Card -->
        <form action="{{ route('client.orders.store') }}" method="POST" enctype="multipart/form-data"
              class="glass-panel p-6 sm:p-10 rounded-[32px] shadow-[0_12px_40px_rgba(0,0,0,0.04)] space-y-6">
            @csrf

            <!-- Pilihan Layanan -->
            <div>
                <label class="block text-xs font-bold text-zinc-700 uppercase tracking-wider mb-2">Layanan yang Dibutuhkan</label>
                <select name="service_id" class="w-full px-4 py-3 rounded-2xl border border-zinc-200 text-sm font-semibold bg-zinc-50 focus:ring-2 focus:ring-[#0071e3] focus:outline-none transition">
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" {{ (old('service_id', $selectedService->id ?? null) == $service->id) ? 'selected' : '' }}>
                            {{ $service->badge }} — {{ $service->title }}
                        </option>
                    @endforeach
                </select>
                @error('service_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Data Diri Mahasiswa -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                    <input type="text" name="client_name" value="{{ old('client_name', Auth::user()->name ?? '') }}" required placeholder="Contoh: Muhammad Raihan"
                           class="w-full px-4 py-3 rounded-2xl border border-zinc-200 text-sm focus:ring-2 focus:ring-[#0071e3] focus:outline-none bg-zinc-50 transition">
                    @error('client_name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Asal Universitas</label>
                    <input type="text" name="client_campus" value="{{ old('client_campus') }}" placeholder="Contoh: Universitas Indonesia"
                           class="w-full px-4 py-3 rounded-2xl border border-zinc-200 text-sm focus:ring-2 focus:ring-[#0071e3] focus:outline-none bg-zinc-50 transition">
                </div>
            </div>

          <div>
    <label class="block text-xs font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Nomor WhatsApp Aktif</label>
    <input type="text" name="client_whatsapp" value="{{ old('client_whatsapp') }}" required placeholder="Contoh: 08123456789"
           class="w-full px-4 py-3 rounded-2xl border border-zinc-200 text-sm focus:ring-2 focus:ring-[#0071e3] focus:outline-none bg-zinc-50 transition">
    @error('client_whatsapp') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
</div>

            <!-- Catatan / Spesifikasi Proyek -->
            <div>
                <label class="block text-xs font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Catatan Khusus / Deskripsi Kendala</label>
                <textarea name="notes" rows="4" placeholder="Tuliskan judul bab, deadline yang diharapkan, software yang diinginkan, dsb..."
                          class="w-full px-4 py-3 rounded-2xl border border-zinc-200 text-sm focus:ring-2 focus:ring-[#0071e3] focus:outline-none bg-zinc-50 transition">{{ old('notes') }}</textarea>
            </div>

            <!-- Upload Berkas Mentah -->
            <div>
                <label class="block text-xs font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Lampirkan Berkas / Draft (Opsional)</label>
                <input type="file" name="client_file"
                       class="w-full text-xs text-zinc-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#0071e3] hover:file:bg-blue-100 cursor-pointer">
                <span class="text-[11px] text-zinc-400 mt-1.5 block">Format DOCX, PDF, ZIP, RAR, atau XLS (Maksimal 25MB).</span>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit" class="w-full py-3.5 rounded-full bg-[#0071e3] hover:bg-[#0077ed] text-white font-bold text-sm shadow-[0_4px_16px_rgba(0,113,227,0.3)] transition active:scale-[0.98]">
                    Kirim Pesanan & Ajukan Berkas
                </button>
                <a href="{{ route('home') }}" class="block text-center text-xs font-medium text-zinc-400 hover:text-zinc-600 mt-3 transition">
                    Batal dan kembali ke beranda
                </a>
            </div>
        </form>
    </div>

</body>
</html>

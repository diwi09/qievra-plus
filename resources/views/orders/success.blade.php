<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil — Menghubungkan ke WhatsApp...</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #fafafa; color: #1d1d1f; }
        .glass-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border: 1px solid rgba(0, 0, 0, 0.07); }
    </style>
</head>
<body class="antialiased min-h-screen py-12 px-4 flex flex-col items-center justify-center">

    <div class="max-w-md w-full glass-card p-8 sm:p-10 rounded-[32px] shadow-[0_12px_40px_rgba(0,0,0,0.05)] text-center space-y-6">

        <!-- Status Icon Animasi -->
        <div class="relative w-20 h-20 mx-auto">
            <div class="absolute inset-0 rounded-full bg-emerald-500/20 animate-ping"></div>
            <div class="relative w-20 h-20 rounded-full bg-emerald-500 text-white flex items-center justify-center text-3xl font-bold shadow-lg shadow-emerald-500/30">
                ✓
            </div>
        </div>

        <div>
            <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest font-mono">Pesanan Tersimpan</span>
            <h1 class="text-2xl font-extrabold text-zinc-900 tracking-tight mt-1">
                Menghubungkan ke WhatsApp...
            </h1>
            <p class="text-xs text-zinc-500 mt-1.5 leading-relaxed">
                Detail pesanan Anda berhasil disimpan ke sistem. Halaman ini akan membuka WhatsApp Admin secara otomatis.
            </p>
        </div>

        <!-- Ringkasan Kode Order -->
        <div class="p-4 rounded-2xl bg-zinc-50 border border-zinc-100 font-mono text-left space-y-2 text-xs">
            <div class="flex justify-between items-center text-zinc-500 border-b border-zinc-200/60 pb-2">
                <span>Kode Order:</span>
                <span class="font-bold text-zinc-900 text-sm bg-white px-2 py-0.5 rounded border border-zinc-200">
                    {{ $order->order_code }}
                </span>
            </div>
            <div class="flex justify-between text-zinc-500">
                <span>Mahasiswa:</span>
                <span class="font-semibold text-zinc-800">{{ $order->client_name }}</span>
            </div>
            <div class="flex justify-between text-zinc-500">
                <span>Layanan:</span>
                <span class="font-semibold text-zinc-800">{{ $order->service->title ?? $order->service_title }}</span>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="space-y-2.5 pt-2">
            <a id="wa-btn" href="{{ $waUrl }}"
               class="inline-flex items-center justify-center gap-2 w-full py-3.5 rounded-full bg-[#25D366] hover:bg-[#20bd5a] text-white text-xs font-bold transition shadow-lg shadow-emerald-500/20 active:scale-95">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                </svg>
                <span>Buka WhatsApp Sekarang</span>
            </a>

            <a href="{{ route('home') }}" class="block w-full py-2.5 rounded-full bg-zinc-100 text-zinc-600 text-xs font-semibold hover:bg-zinc-200 transition">
                Kembali ke Beranda QIEVRA+
            </a>
        </div>

    </div>

    <!-- Skrip Otomatis Redirect ke WhatsApp -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const waUrl = @json($waUrl);
            setTimeout(() => {
                window.location.href = waUrl;
            }, 1200);
        });
    </script>
</body>
</html>

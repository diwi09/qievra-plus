<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — QIEVRA+</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            background-color: #fbfbfd;
        }
        .ambient-glow {
            background: radial-gradient(circle at 50% 20%, rgba(0, 113, 227, 0.1) 0%, rgba(245, 158, 11, 0.05) 40%, transparent 70%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4 py-12 selection:bg-blue-600 selection:text-white relative overflow-hidden">

    <!-- Ambient Background Light -->
    <div class="fixed inset-0 pointer-events-none z-0 ambient-glow"></div>

    <div class="w-full max-w-[400px] relative z-10 space-y-6">

        <!-- Logo & Header Brand -->
        <div class="text-center space-y-2">
            <a href="{{ route('home') }}" class="inline-flex items-center space-x-2.5 group">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Qievra Plus" class="h-9 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                <div class="flex items-center tracking-wider font-extrabold text-xl select-none">
                    <span class="text-[#0B1E48] tracking-[0.18em]">QIEVRA</span>
                    <span class="text-[#F59E0B] ml-0.5 text-2xl font-black -translate-y-0.5">+</span>
                </div>
            </a>
            <h1 class="text-xl font-extrabold text-zinc-950 pt-2 tracking-tight">Selamat Datang Kembali</h1>
            <p class="text-xs text-zinc-500">Masuk untuk melihat progres pengerjaan dan berkas tugas akhir Anda</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white/90 backdrop-blur-xl p-8 rounded-3xl border border-zinc-200/80 shadow-xl shadow-zinc-200/50">
            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-2xl bg-red-50 border border-red-200/60 text-xs text-red-600 space-y-1">
                    @foreach ($errors->all() as $error)
                        <p class="flex items-center space-x-1">
                            <span>⚠</span>
                            <span>{{ $error }}</span>
                        </p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-zinc-700 mb-1.5" for="email">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           placeholder="nama@email.com"
                           class="w-full px-3.5 py-2.5 text-sm bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0071e3]/20 focus:border-[#0071e3] transition">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label class="block text-xs font-semibold text-zinc-700" for="password">Kata Sandi</label>
                        <a href="https://wa.me/" target="_blank" class="text-[11px] text-[#0071e3] hover:underline font-medium">Bantuan sandi?</a>
                    </div>
                    <input type="password" name="password" id="password" required
                           placeholder="••••••••"
                           class="w-full px-3.5 py-2.5 text-sm bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0071e3]/20 focus:border-[#0071e3] transition">
                </div>

                <div class="flex items-center text-xs">
                    <label class="flex items-center text-zinc-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-zinc-300 text-[#0071e3] focus:ring-[#0071e3]/30">
                        <span class="ml-2">Ingat perangkat ini</span>
                    </label>
                </div>

                <button type="submit"
                        class="w-full py-2.5 bg-[#0071e3] hover:bg-blue-600 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-500/20 active:scale-[0.98] transition duration-200">
                    Masuk ke Akun
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-zinc-100 text-center text-xs text-zinc-500">
                Belum memiliki akun?
                <a href="{{ route('register') }}" class="text-[#0071e3] font-bold hover:underline ml-0.5">Daftar Sekarang</a>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('home') }}" class="text-xs text-zinc-400 hover:text-zinc-700 transition">
                ← Kembali ke Beranda Utama
            </a>
        </div>
    </div>

</body>
</html>

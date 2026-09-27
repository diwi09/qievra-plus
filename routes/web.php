<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\ClientOrderController;
use App\Models\Service;
use App\Models\Order;

// 1. Halaman Beranda (Landing Page) dengan Fallback Aman untuk Vercel
Route::get('/', function () {
    try {
        $services = Service::where('is_active', true)
            ->orderBy('order_position', 'asc')
            ->get();
    } catch (\Throwable $th) {
        // Fallback jika database belum terhubung di Vercel
        $services = collect([
            (object) [
                'id' => 1,
                'title' => 'Pengembangan Sistem & Aplikasi Web/Mobile',
                'description' => 'Rancang bangun website, aplikasi Android/iOS, dashboard analitik, dan sistem informasi tugas akhir dengan arsitektur modern.',
                'badge' => 'FULL-STACK DEV',
                'badge_color' => 'blue',
                'image_url' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?q=80&w=1200&auto=format&fit=crop'
            ],
            (object) [
                'id' => 2,
                'title' => 'Olah Data Statistik & Analisis Kuantitatif/Kualitatif',
                'description' => 'Pendampingan olah data skripsi/tesis menggunakan SPSS, SmartPLS, SEM-AMOS, EViews, Python, dan R-Studio teruji akurat.',
                'badge' => 'DATA ANALYTICS',
                'badge_color' => 'emerald',
                'image_url' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=1200&auto=format&fit=crop'
            ],
            (object) [
                'id' => 3,
                'title' => 'Editing & Parafrase Naskah Skripsi / Tesis',
                'description' => 'Penyelarasan format template kampus, sitasi Mendeley/Zotero, penulisan metodologi, dan uji lolos Turnitin di bawah batas toleransi.',
                'badge' => 'ACADEMIC WRITING',
                'badge_color' => 'purple',
                'image_url' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?q=80&w=1200&auto=format&fit=crop'
            ]
        ]);
    }

    return view('welcome', compact('services'));
})->name('home');

// 2. Guest Routes (Login & Register)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// 3. Logout (Untuk semua user login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// 4. Admin Workspace Terproteksi
Route::middleware(['auth', 'admin'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Layanan Slider
    Route::resource('services', ServiceController::class)->names([
        'index'   => 'dashboard.services.index',
        'create'  => 'dashboard.services.create',
        'store'   => 'dashboard.services.store',
        'edit'    => 'dashboard.services.edit',
        'update'  => 'dashboard.services.update',
        'destroy' => 'dashboard.services.destroy',
    ]);

    // Manajemen Pesanan & Berkas Masuk
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'update', 'destroy'])->names([
        'index'   => 'dashboard.orders.index',
        'show'    => 'dashboard.orders.show',
        'update'  => 'dashboard.orders.update',
        'destroy' => 'dashboard.orders.destroy',
    ]);
});

// 5. Alur Pemesanan Klien
Route::get('/pesan-layanan', [ClientOrderController::class, 'create'])->name('client.orders.create');
Route::post('/pesan-layanan', [ClientOrderController::class, 'store'])->name('client.orders.store');
Route::get('/pesanan-berhasil/{order_code}', [ClientOrderController::class, 'success'])->name('client.orders.success');

// 6. Riwayat Pesanan Klien (Pencarian via No. WhatsApp atau Kode Order)
Route::get('/cek-pesanan', function (Request $request) {
    $orders = collect([]);
    $searched = false;
    $keyword = trim($request->query('q', ''));

    if (!empty($keyword)) {
        $searched = true;
        $cleanPhone = preg_replace('/[^0-9]/', '', $keyword);

        try {
            $orders = Order::with('service')
                ->where(function ($query) use ($keyword, $cleanPhone) {
                    $query->where('order_code', 'like', "%{$keyword}%");

                    if (!empty($cleanPhone)) {
                        $query->orWhere('client_whatsapp', 'like', "%{$cleanPhone}%");
                    }
                })
                ->latest()
                ->get();
        } catch (\Throwable $th) {
            $orders = collect([]);
        }
    }

    return view('orders.track', compact('orders', 'searched', 'keyword'));
})->name('client.orders.track');

// 7. Rincian Tunggal Pesanan & Berkas Klien
Route::get('/pesanan/{order_code}', function ($order_code) {
    $order = Order::with('service')->where('order_code', $order_code)->firstOrFail();
    return view('orders.client_detail', compact('order'));
})->name('client.orders.detail');

// 8. Rute Unduh Berkas Hasil
Route::get('/unduh-hasil/{order_code}', function ($order_code) {
    $order = Order::where('order_code', $order_code)->firstOrFail();

    if (!$order->result_file_path || !Storage::disk('public')->exists($order->result_file_path)) {
        abort(404, 'Berkas pengerjaan belum tersedia atau file fisik tidak ditemukan di server.');
    }

    $absolutePath = Storage::disk('public')->path($order->result_file_path);
    $extension = pathinfo($absolutePath, PATHINFO_EXTENSION) ?: 'zip';
    $cleanClientName = Str::slug($order->client_name) ?: 'klien';
    $downloadFileName = 'HASIL-' . $order->order_code . '-' . strtoupper($cleanClientName) . '.' . $extension;

    return response()->download($absolutePath, $downloadFileName);
})->name('client.orders.download');

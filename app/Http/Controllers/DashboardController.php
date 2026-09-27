<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Metrik Operasional Real-time
        $totalOrders = Order::count();
        $inProgress  = Order::whereIn('status', ['Diproses', 'Proses'])->count();
        $completed   = Order::where('status', 'Selesai')->count();
        $totalRevenue = Order::where('status', 'Selesai')->sum('price');

        $metrics = [
            'total_orders' => $totalOrders,
            'in_progress'  => $inProgress,
            'completed'    => $completed,
            'revenue'      => 'Rp ' . number_format($totalRevenue, 0, ',', '.'),
        ];

        // 2. Ambil 5 Pesanan Terbaru untuk Tabel Overview
        $recentOrders = Order::with('service')->latest()->take(5)->get();

        // 3. Cadangan variabel $orders agar view tidak melempar 'Undefined variable'
        $orders = $recentOrders;

        return view('dashboard.index', compact('metrics', 'recentOrders', 'orders'));
    }
}

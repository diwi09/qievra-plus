<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('service')->latest();

        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Pencarian berdasarkan kode order, nama klien, atau kampus
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%")
                  ->orWhere('client_campus', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(10)->withQueryString();

        $metrics = [
            'total'       => Order::count(),
            'pending'     => Order::where('status', 'Pending')->count(),
            'in_progress' => Order::whereIn('status', ['Diproses', 'Proses'])->count(),
            'revision'    => Order::where('status', 'Revisi')->count(),
            'completed'   => Order::where('status', 'Selesai')->count(),
        ];

        return view('dashboard.orders.index', compact('orders', 'metrics'));
    }

    public function show(Order $order)
    {
        $order->load('service');
        return view('dashboard.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status'      => ['required', 'in:Pending,Diproses,Revisi,Selesai'],
            'price'       => ['nullable', 'numeric', 'min:0'],
            'admin_note'  => ['nullable', 'string'],
            'result_file' => ['nullable', 'file', 'max:25600'], // Maksimal 25MB
        ]);

        $order->status = $validated['status'];

        if ($request->filled('price')) {
            $order->price = $validated['price'];
        }

        if ($request->filled('admin_note')) {
            $order->admin_note = $validated['admin_note'];
        }

        // Pengunggahan berkas hasil pengerjaan
        if ($request->hasFile('result_file')) {
            if ($order->result_file_path && Storage::disk('public')->exists($order->result_file_path)) {
                Storage::disk('public')->delete($order->result_file_path);
            }
            $order->result_file_path = $request->file('result_file')->store('order_results', 'public');
        }

        $order->save();

        return redirect()->route('dashboard.orders.show', $order)
            ->with('success', 'Status pesanan, biaya, dan berkas berhasil diperbarui.');
    }

    public function destroy(Order $order)
    {
        // Bersihkan berkas klien jika ada di storage
        if ($order->client_file_path && Storage::disk('public')->exists($order->client_file_path)) {
            Storage::disk('public')->delete($order->client_file_path);
        }

        // Bersihkan berkas hasil revisi jika ada
        if ($order->result_file_path && Storage::disk('public')->exists($order->result_file_path)) {
            Storage::disk('public')->delete($order->result_file_path);
        }

        $order->delete();

        return redirect()->route('dashboard.orders.index')
            ->with('success', 'Data pesanan dan seluruh berkas terkait berhasil dihapus.');
    }
}

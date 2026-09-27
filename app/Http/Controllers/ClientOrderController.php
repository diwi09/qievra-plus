<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientOrderController extends Controller
{
    public function create(Request $request)
    {
        $services = Service::where('is_active', true)->orderBy('order_position', 'asc')->get();
        $selectedServiceId = $request->query('service_id');
        $selectedService = $services->firstWhere('id', $selectedServiceId) ?? $services->first();

        return view('orders.create', compact('services', 'selectedService'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id'      => ['required', 'exists:services,id'],
            'client_name'     => ['required', 'string', 'max:150'],
            'client_campus'   => ['nullable', 'string', 'max:150'],
            'client_whatsapp' => ['required', 'string', 'max:25'], // Ganti ke client_whatsapp
            'notes'           => ['nullable', 'string'],
            'client_file'     => ['nullable', 'file', 'max:25600'],
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $orderCode = 'ORD-' . date('Y') . '-' . strtoupper(Str::random(4));

        $clientFilePath = null;
        if ($request->hasFile('client_file')) {
            $clientFilePath = $request->file('client_file')->store('client_uploads', 'public');
        }

        // Simpan ke database dengan kolom client_whatsapp
    // Simpan ke database tanpa kolom service_title
        $order = Order::create([
            'order_code'        => $orderCode,
            'service_id'        => $service->id,
            'client_name'       => $validated['client_name'],
            'client_campus'     => $validated['client_campus'] ?? '-',
            'client_whatsapp'   => $validated['client_whatsapp'],
            'notes'             => $validated['notes'],
            'client_file_path'  => $clientFilePath,
            'status'            => 'Pending',
            'price'             => 0,
        ]);
        return redirect()->route('client.orders.success', $order->order_code);
    }

 public function success($order_code)
    {
        $order = Order::with('service')->where('order_code', $order_code)->firstOrFail();

        $pesanWa = "Halo Admin QIEVRA+, saya telah mengajukan pesanan layanan via Website.\n\n"
            . "📋 *DETAIL PESANAN:*\n"
            . "• *Kode Order:* " . $order->order_code . "\n"
            . "• *Nama Mahasiswa:* " . $order->client_name . "\n"
            . "• *Kampus/Institusi:* " . ($order->client_campus ?? '-') . "\n"
            . "• *No. WhatsApp:* " . ($order->client_whatsapp ?? '-') . "\n"
            . "• *Layanan:* " . ($order->service->title ?? 'Layanan Riset & Akademik') . "\n"
            . "• *Catatan:* " . ($order->notes ?? 'Tidak ada catatan tambahan') . "\n\n"
            . "Mohon info tindak lanjut dan estimasi pengerjaannya. Terima kasih!";

        $waUrl = "https://api.whatsapp.com/send?phone=6282268925885&text=" . urlencode($pesanWa);

        return view('orders.success', compact('order', 'waUrl'));
    }
}

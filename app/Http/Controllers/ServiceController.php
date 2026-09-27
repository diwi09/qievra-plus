<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('order_position', 'asc')->get();
        return view('dashboard.services.index', compact('services'));
    }

    public function create()
    {
        return view('dashboard.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'badge' => ['required', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image_url' => ['required', 'url'],
            'badge_color' => ['required', 'in:blue,purple,emerald,amber'],
            'order_position' => ['required', 'integer', 'min:1'],
            'is_active' => ['nullable'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        Service::create($validated);

        return redirect()->route('dashboard.services.index')
            ->with('success', 'Layanan baru berhasil disinkronkan ke beranda.');
    }

    public function edit(Service $service)
    {
        return view('dashboard.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'badge' => ['required', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image_url' => ['required', 'url'],
            'badge_color' => ['required', 'in:blue,purple,emerald,amber'],
            'order_position' => ['required', 'integer', 'min:1'],
            'is_active' => ['nullable'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        $service->update($validated);

        return redirect()->route('dashboard.services.index')
            ->with('success', 'Perubahan layanan berhasil diperbarui pada beranda.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('dashboard.services.index')
            ->with('success', 'Layanan berhasil dihapus dari sistem.');
    }
}

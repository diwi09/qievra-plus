<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Jika belum login, lempar ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Izinkan jika rolenya 'admin' ATAU emailnya 'admin@aksaraplus.com'
        if ($user->role === 'admin' || $user->email === 'admin@aksaraplus.com') {
            return $next($request);
        }

        // 3. Jika bukan admin, logout dan tolak akses
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->withErrors([
            'email' => 'Akses ditolak. Halaman ini hanya untuk Administrator.',
        ]);
    }
}

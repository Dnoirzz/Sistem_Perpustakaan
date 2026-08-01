<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        // Cek status verifikasi akun (Login Blocking)
        if ($user && $user->isPending()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda belum terverifikasi oleh Petugas Perpustakaan. Silakan periksa inbox/spam email Anda secara berkala untuk info hasil verifikasi.',
            ]);
        }

        $request->session()->regenerate();

        \App\Models\ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Melakukan login ke sistem',
        ]);

        return redirect()->route('dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            \App\Models\ActivityLog::create([
                'user_id' => Auth::id(),
                'activity' => 'Melakukan logout dari sistem',
            ]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

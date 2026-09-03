<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username wajib diisi!',
            'password.required' => 'Password wajib diisi!',
        ]);


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang Kembali, Admin!');
            }

            return redirect()->intended(route('user.dashboard'))
                ->with('success', 'Selamat bermain!');
        }

        // 4. Jika Login Gagal
        return back()->withErrors([
            'username' => 'Username yang Anda masukkan salah.',
            'password' => 'Password yang Anda masukkan salah.'
        ])->onlyInput('username');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function logout(Request $request)
    {
        // 1. Keluar dari guard autentikasi Laravel (menghapus status login user)
        Auth::logout();

        // 2. Menghancurkan session yang sedang berjalan (keamanan dari session hijacking)
        $request->session()->invalidate();

        // 3. Membuat ulang CSRF token baru untuk keamanan request selanjutnya
        $request->session()->regenerateToken();

        // 4. Arahkan kembali ke halaman login dengan pesan sukses
        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}
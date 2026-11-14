<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username wajib diisi!',
            'password.required' => 'Password wajib diisi!',
        ]);

        $credentials['role'] = 'admin';

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang kembali, Admin!');
        }

        return back()->withErrors([
            'username' => 'Akun admin atau password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^[0-9]{10,15}$/', 'unique:users,username'],
        ], [
            'phone.required' => 'Nomor HP wajib diisi!',
            'phone.regex' => 'Nomor HP harus terdiri dari 10 sampai 15 digit angka.',
            'phone.unique' => 'Nomor HP ini sudah terdaftar!',
        ]);

        $animals = ['panda', 'tiger', 'fox', 'cat', 'rabbit', 'bear', 'koala', 'penguin'];

        User::create([
            'name' => $validated['name'],
            'username' => $validated['phone'],
            'email' => 'player-'.Str::uuid().'@players.invalid',
            'birth_date' => '1000-01-01',
            'profile_picture' => $animals[random_int(0, count($animals) - 1)],
            'password' => Hash::make(Str::random(64)),
            'role' => 'user',
        ]);

        return redirect()->route('register')->with('success', 'Pendaftaran berhasil! Data Anda sudah tercatat. Anda tidak perlu login.');
    }

    public function logout(Request $request): RedirectResponse
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

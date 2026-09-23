<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            'password' => 'Password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validasi Input Form
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'birth_month' => ['required', 'integer', 'between:1,12'],
            'birth_day' => ['required', 'integer', 'between:1,31'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'username.unique' => 'Username ini sudah digunakan!',
            'email.unique' => 'Email ini sudah terdaftar!',
            'password.min' => 'Password minimal 6 karakter!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!',
        ]);

        if (! checkdate($validated['birth_month'], $validated['birth_day'], 2000)) {
            return back()->withErrors(['birth_day' => 'Tanggal lahir tidak valid.'])->withInput();
        }

        $animals = ['panda', 'tiger', 'fox', 'cat', 'rabbit', 'bear', 'koala', 'penguin'];

        // 2. Simpan Data Baru ke Database SQLite
        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'birth_date' => sprintf('%04d-%02d-%02d', 2000, $validated['birth_month'], $validated['birth_day']),
            'profile_picture' => $animals[random_int(0, count($animals) - 1)],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        // 3. Otomatis Login Setelah Berhasil Daftar
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('user.dashboard')->with('success', 'Registrasi berhasil! Selamat datang di Fun Mahjong.');
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

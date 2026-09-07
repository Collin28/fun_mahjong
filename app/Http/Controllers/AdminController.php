<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    //main dashboard
    public function index()
    {
        $users = User::where('role', 'user')->latest()->get()->map(function ($user) {
            $user->profile_picture = asset("assets/profile/{$user->username}.png");
            $user->is_birthday = Carbon::parse($user->birth_date)->isBirthday();
            return $user;
        });

        return view('admin.dashboard', compact('users'));
    }

    //add poin
    // public function addPoint(Request $request)
    // {
    //     $request->validate([
    //         'username' => 'required|string|exists:users,username',
    //         'points' => 'required|integer|min:1',
    //     ], [
    //         'username.exists' => 'Username tersebut tidak ditemukan.',
    //     ]);

    //     $user = User::where('username', $request->player_username)->firstOrFail();
    //     $user->increment('total_wins', $request->points);

    //     return redirect()->route('admin.dashboard')
    //         ->with('success', "Poin kemenangan (+{$request->points}) berhasil ditambahkan ke {$user->username}.");
    // }

    //add match 
    public function addMatch(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'username' => 'required|string',
            'total_played' => 'required|integer|min:1',
        ], [
            'username.required' => 'Username player wajib diisi.',
            'total_played.required' => 'Jumlah match wajib diisi.',
            'total_played.min' => 'Jumlah match minimal adalah 1.',
        ]);

        // 2. Cari User
        $user = User::where('username', $request->username)
            ->orWhere('name', $request->username)
            ->first();

        if (!$user) {
            return redirect()->back()->withErrors(['username' => 'Player tidak ditemukan di database.']);
        }

        // 3. Tambahkan Nilai ke Daily, Weekly, dan Total Match
        // (Sesuaikan nama kolom di bawah dengan yang ada di database kamu)
        $user->daily_played = ($user->daily_played ?? 0) + $request->total_played;
        $user->weekly_played = ($user->weekly_played ?? 0) + $request->total_played;
        $user->total_played = ($user->total_played ?? 0) + $request->total_played;

        // 4. Simpan ke Database
        $user->save();

        return redirect()->route('admin.dashboard')
            ->with('success', "Berhasil menambahkan {$request->total_played} match (Daily, Weekly & Total) untuk @{$user->username}.");
    }

    //Manager Users
    public function manageUsersIndex()
    {
        $users = User::where('role', 'user')->latest()->get();

        return view('admin.users.index', compact('users'));
    }

    // SHOW: Tampilkan detail user
    public function manageUsersShow($id)
    {
        $user = User::findOrFail($id);
        // Mengarahkan ke resources/views/admin/users/show.blade.php
        return view('admin.users.show', compact('user'));
    }

    // UPDATE FORM: Tampilkan form edit user (opsional jika pakai halaman terpisah)
    public function manageUsersEdit($id)
    {
        $user = User::findOrFail($id);
        // Mengarahkan ke resources/views/admin/users/update.blade.php
        return view('admin.users.edit', compact('user'));
    }

    // UPDATE PROCESS: Proses pembaruan data user
    public function manageUsersUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'birth_date' => ['required', 'date'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'birth_date' => $request->birth_date,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    // DELETE: Hapus user
    public function manageUsersDestroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}
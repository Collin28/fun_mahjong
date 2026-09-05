<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Dashboard Utama
     */
    public function index()
    {
        $users = User::all()->map(function ($user) {
            $user->profile_picture = asset("assets/profile/{$user->username}.png");
            $user->is_birthday = Carbon::parse($user->birth_date)->isBirthday();
            return $user;
        });

        return view('admin.dashboard', compact('users'));
    }

    /**
     * Tambah Poin / Kemenangan
     */
    public function addPoint(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'points'  => 'required|integer|min:1',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->increment('total_wins', $request->points);
        $user->increment('weekly_wins', $request->points);

        $leaderboard = User::orderBy('total_wins', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Poin berhasil ditambahkan!',
            'data'    => $leaderboard
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | MANAGE USERS (Disesuaikan dengan folder admin/users/)
    |--------------------------------------------------------------------------
    */

    // READ ALL: Tampilkan tabel daftar user
    public function manageUsersIndex()
    {
        $users = User::all();
        // Mengarahkan ke resources/views/admin/users/index.blade.php
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
            'name'       => ['required', 'string', 'max:255'],
            'username'   => ['required', 'string', 'max:255', 'unique:users,username,' . $id],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'birth_date' => ['required', 'date'],
            'password'   => ['nullable', 'string', 'min:6'],
        ]);

        $data = [
            'name'       => $request->name,
            'username'   => $request->username,
            'email'      => $request->email,
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

    /*
    |--------------------------------------------------------------------------
    | FITUR LEADERBOARD
    |--------------------------------------------------------------------------
    */

    public function getLeaderboard(Request $request)
    {
        $type = $request->query('type', 'top_player');
        $query = User::query();

        switch ($type) {
            case 'top_loyal':
                $query->orderBy('total_played', 'desc');
                break;
            case 'weekly':
                $query->where('updated_at', '>=', Carbon::now()->subDays(7))
                    ->orderBy('weekly_wins', 'desc');
                break;
            case 'daily':
                $query->where('updated_at', '>=', Carbon::now()->subDay())
                    ->orderBy('weekly_wins', 'desc');
                break;
            case 'top_player':
            default:
                $query->orderBy('total_wins', 'desc');
                break;
        }

        return response()->json([
            'success' => true,
            'type'    => $type,
            'data'    => $query->get()
        ]);
    }

    public function resetWeeklyLeaderboard()
    {
        User::query()->update(['weekly_wins' => 0]);

        return response()->json([
            'success' => true,
            'message' => 'Leaderboard mingguan berhasil di-reset!'
        ]);
    }
}
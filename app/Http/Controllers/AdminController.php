<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Menampilkan halaman dashboard / data semua user
     */
    public function index()
    {
        $users = User::all()->map(function ($user) {
            // Path avatar sesuai spesifikasi: /assets/profile/username.png
            $user->profile_picture = asset("assets/profile/{$user->username}.png");
            
            // Cek apakah user ulang tahun hari ini
            $user->is_birthday = Carbon::parse($user->birth_date)->isBirthday();
            
            return $user;
        });

        // Jika menggunakan Blade View:
        return view('admin.dashboard', compact('users'));

        // Jika menggunakan API (Vue / React / Fetch JS):
        // return response()->json(['success' => true, 'data' => $users]);
    }

    /**
     * Tambah Poin / Kemenangan & Auto-Sort
     */
    public function addPoint(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'points'  => 'required|integer|min:1',
        ]);

        $user = User::findOrFail($request->user_id);
        
        // Tambahkan poin ke total_wins dan weekly_wins
        $user->increment('total_wins', $request->points);
        $user->increment('weekly_wins', $request->points);

        // Ambil data leaderboard terbaru (otomatis terurut dari poin terbesar)
        $leaderboard = User::orderBy('total_wins', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Poin berhasil ditambahkan!',
            'data'    => $leaderboard
        ]);
    }

    /**
     * Filter Leaderboard berdasarkan Kategori (Daily, Weekly, Top Player, Top Loyal)
     */
    public function getLeaderboard(Request $request)
    {
        $type = $request->query('type', 'top_player');

        $query = User::query();

        switch ($type) {
            case 'top_loyal':
                // Urutan paling sering main
                $query->orderBy('total_played', 'desc');
                break;

            case 'weekly':
                // Filter 7 hari ke belakang / berdasarkan weekly_wins
                $query->where('updated_at', '>=', Carbon::now()->subDays(7))
                      ->orderBy('weekly_wins', 'desc');
                break;

            case 'daily':
                // Filter 1 hari terakhir
                $query->where('updated_at', '>=', Carbon::now()->subDay())
                      ->orderBy('weekly_wins', 'desc');
                break;

            case 'top_player':
            default:
                // Urutan paling banyak menang (All-Time)
                $query->orderBy('total_wins', 'desc');
                break;
        }

        $leaderboard = $query->get();

        return response()->json([
            'success' => true,
            'type'    => $type,
            'data'    => $leaderboard
        ]);
    }

    /**
     * Reset Leaderboard Periodik (Sistem Rentang 7 Hari)
     */
    public function resetWeeklyLeaderboard()
    {
        // Reset poin mingguan menjadi 0
        User::query()->update(['weekly_wins' => 0]);

        return response()->json([
            'success' => true,
            'message' => 'Leaderboard mingguan berhasil di-reset!'
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // main dashboard
    public function index()
    {
        $users = $this->decorateUsers(User::where('role', 'user')->latest()->get());

        // Leaderboard per kategori: daily, weekly, top player (menang), top loyal (sering main)
        $dailyUsers = $this->decorateUsers(User::where('role', 'user')->orderByDesc('daily_played')->orderBy('username')->get());
        $weeklyUsers = $this->decorateUsers(User::where('role', 'user')->orderByDesc('weekly_played')->orderBy('username')->get());
        $topPlayers = $this->decorateUsers(User::where('role', 'user')->orderByRaw('(hu_points + zi_mo_points) DESC')->orderBy('username')->get());
        $topLoyal = $this->decorateUsers(User::where('role', 'user')->orderByDesc('total_played')->orderBy('username')->get());

        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        return view('admin.dashboard', compact(
            'users',
            'dailyUsers',
            'weeklyUsers',
            'topPlayers',
            'topLoyal',
            'weekStart',
            'weekEnd'
        ));
    }

    // helper: melengkapi atribut tambahan untuk tiap user
    private function decorateUsers($users)
    {
        return $users->map(function ($user) {
            $user->is_birthday = Carbon::parse($user->birth_date)->isBirthday();

            return $user;
        });
    }

    // adjust stat via AJAX (+/- button)
    // adjust stat via AJAX (+/- button & input manual)
    public function adjustStat(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'group' => 'required|string|in:wins,matches,hu,zi_mo',
            'delta' => 'required|integer', // Hapus 'in:-1,1' agar mendukung input manual dengan angka bebas
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan.'], 404);
        }

        switch ($request->group) {
            case 'wins':
                $columns = ['total_wins', 'weekly_wins'];
                break;

            case 'matches':
                $columns = ['daily_played', 'weekly_played', 'total_played'];
                break;

            case 'hu':
                $columns = ['hu_points'];
                break;

            case 'zi_mo':
            default:
                $columns = ['zi_mo_points'];
                break;
        }

        // Hitung nilai baru untuk kolom yang relevan
        $values = [];
        foreach ($columns as $column) {
            $values[$column] = max(0, ($user->$column ?? 0) + $request->delta);
            $user->$column = $values[$column];
        }

        // Jika merubah poin Hu atau Zi Mo, kalkulasi ulang total_wins & weekly_wins
        if (in_array($request->group, ['hu', 'zi_mo'], true)) {
            $oldTotalWins = $user->total_wins ?? 0;
            $newTotalWins = ($user->hu_points ?? 0) + ($user->zi_mo_points ?? 0);

            // Hitung selisih untuk menambah/mengurangi weekly_wins
            $winDelta = $newTotalWins - $oldTotalWins;

            $user->total_wins = $newTotalWins;
            $user->weekly_wins = max(0, ($user->weekly_wins ?? 0) + $winDelta);

            // Masukkan ke array response agar JS memperbarui tampilan "Total Menang" secara real-time
            $values['total_wins'] = $user->total_wins;
            $values['weekly_wins'] = $user->weekly_wins;
        }

        $user->save();

        return response()->json($values);
    }

    // add poin (legacy form — kept for fallback)
    public function addPoint(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'points' => 'required|integer|min:1',
        ]);

        $user = User::where('username', $request->username)
            ->orWhere('name', $request->username)
            ->first();

        if (!$user) {
            return redirect()->back()->withErrors(['username' => 'Player tidak ditemukan di database.']);
        }

        $user->total_wins = ($user->total_wins ?? 0) + $request->points;
        $user->weekly_wins = ($user->weekly_wins ?? 0) + $request->points;
        $user->save();

        return redirect()->route('admin.dashboard')
            ->with('success', "Poin kemenangan (+{$request->points}) berhasil ditambahkan ke @{$user->username}.");
    }

    // add match (legacy form — kept for fallback)
    public function addMatch(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'total_played' => 'required|integer|min:1',
        ]);

        $user = User::where('username', $request->username)
            ->orWhere('name', $request->username)
            ->first();

        if (!$user) {
            return redirect()->back()->withErrors(['username' => 'Player tidak ditemukan di database.']);
        }

        $user->daily_played = ($user->daily_played ?? 0) + $request->total_played;
        $user->weekly_played = ($user->weekly_played ?? 0) + $request->total_played;
        $user->total_played = ($user->total_played ?? 0) + $request->total_played;
        $user->save();

        return redirect()->route('admin.dashboard')
            ->with('success', "Berhasil menambahkan {$request->total_played} match untuk @{$user->username}.");
    }

    // reset leaderboard mingguan
    public function resetWeeklyLeaderboard()
    {
        User::where('role', 'user')->update([
            'weekly_played' => 0,
            'weekly_wins' => 0,
            'last_weekly_reset' => Carbon::now()->timestamp,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Leaderboard mingguan berhasil di-reset. Semua nilai weekly_played & weekly_wins kembali ke 0.');
    }

    // Manager Users
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

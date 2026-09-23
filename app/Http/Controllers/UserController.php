<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $dailyUsers = User::where('role', 'user')->orderByDesc('daily_played')->orderBy('username')->get();
        $weeklyUsers = User::where('role', 'user')->orderByDesc('weekly_played')->orderBy('username')->get();
        $topPlayers = User::where('role', 'user')->orderByRaw('(hu_points + zi_mo_points) DESC')->orderBy('username')->get();
        $topLoyal = User::where('role', 'user')->orderByDesc('total_played')->orderBy('username')->get();

        $allTimeRank = $this->rankOf($topPlayers, $user);
        $dailyRank = $this->rankOf($dailyUsers, $user);

        return view('user.dashboard', compact(
            'user', 'dailyUsers', 'weeklyUsers', 'topPlayers', 'topLoyal', 'allTimeRank', 'dailyRank'
        ));
    }

    private function rankOf($list, $user)
    {
        $position = $list->search(function ($item) use ($user) {
            return $item->id === $user->id;
        });

        return $position === false ? '-' : $position + 1;
    }
}

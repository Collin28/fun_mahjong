<?php

namespace App\Http\Controllers;

use App\Models\User;

class PublicController extends Controller
{
    private const LEADERBOARD_LIMIT = 10;

    public function index()
    {
        $dailyUsers = User::where('role', 'user')->orderByDesc('daily_played')->orderBy('username')->limit(self::LEADERBOARD_LIMIT)->get();
        $weeklyUsers = User::where('role', 'user')->orderByDesc('weekly_played')->orderBy('username')->limit(self::LEADERBOARD_LIMIT)->get();
        $topPlayers = User::where('role', 'user')->orderByRaw('(hu_points + 2 * zi_mo_points) DESC')->orderBy('username')->limit(self::LEADERBOARD_LIMIT)->get();
        $topLoyal = User::where('role', 'user')->orderByDesc('total_played')->orderBy('username')->limit(self::LEADERBOARD_LIMIT)->get();

        return view('welcome', compact('dailyUsers', 'weeklyUsers', 'topPlayers', 'topLoyal'));
    }

    public function about()
    {
        return view('about');
    }
}

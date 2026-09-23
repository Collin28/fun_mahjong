<?php

namespace App\Http\Controllers;

use App\Models\User;

class PublicController extends Controller
{
    public function index()
    {
        $dailyUsers = User::where('role', 'user')->orderByDesc('daily_played')->orderBy('username')->get();
        $weeklyUsers = User::where('role', 'user')->orderByDesc('weekly_played')->orderBy('username')->get();
        $topPlayers = User::where('role', 'user')->orderByRaw('(hu_points + zi_mo_points) DESC')->orderBy('username')->get();
        $topLoyal = User::where('role', 'user')->orderByDesc('total_played')->orderBy('username')->get();

        return view('welcome', compact('dailyUsers', 'weeklyUsers', 'topPlayers', 'topLoyal'));
    }

    public function about()
    {
        return view('about');
    }
}

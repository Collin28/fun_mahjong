<?php

namespace App\Http\Controllers;

use App\Models\User;

class ScorerController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->orderBy('username')->get();

        return view('scorer.index', compact('users'));
    }
}

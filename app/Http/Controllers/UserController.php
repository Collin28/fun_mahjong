<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->latest()->get();
        
        return view('user.dashboard', compact('users'));

    }

}

<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Admin
Route::prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::post('/leaderboard/add-point', [AdminController::class, 'addPoint'])->name('admin.add-point');

    Route::get('/leaderboard/data', [AdminController::class, 'getLeaderboard'])->name('admin.leaderboard-data');

    Route::post('/leaderboard/reset', [AdminController::class, 'resetWeeklyLeaderboard'])->name('admin.reset-leaderboard');
});



//Manage User (Admin Page)
Route::prefix('admin')->name('admin.')->group(function () {

    // Prefix Khusus Manage Users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminController::class, 'manageUsersIndex'])->name('index');

        Route::get('/{id}', [AdminController::class, 'manageUsersShow'])->name('show');

        Route::get('/{id}/edit', [AdminController::class, 'manageUsersEdit'])->name('edit');

        Route::put('/{id}', [AdminController::class, 'manageUsersUpdate'])->name('update');
        
        Route::delete('/{id}', [AdminController::class, 'manageUsersDestroy'])->name('destroy');
    });

});



//User
Route::prefix('user')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
});


//Auth
Route::middleware('guest')->group(function () {
    // Tampilan Form Login & Register
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

    // Eksekusi Submit Form Login & Register
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [UserController::class, 'index'])->name('user.dashboard');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // URL: /admin/dashboard | Nama Route: admin.dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
});



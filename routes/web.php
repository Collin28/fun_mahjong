<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ScorerController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/about-us', [PublicController::class, 'about'])->name('about');
Route::get('/scorer', [ScorerController::class, 'index'])->name('scorer.index')->middleware(['auth', 'admin']);

// Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::post('/adjust-stat', [AdminController::class, 'adjustStat'])->name('admin.adjust-stat');
    Route::post('/add-point', [AdminController::class, 'addPoint'])->name('admin.add-point');
    Route::post('/add-match', [AdminController::class, 'addMatch'])->name('admin.add-match');

    Route::post('/reset', [AdminController::class, 'resetWeeklyLeaderboard'])->name('admin.reset-leaderboard');
});

// Manage User (Admin Page)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Prefix Khusus Manage Users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminController::class, 'manageUsersIndex'])->name('index');

        Route::get('/{id}', [AdminController::class, 'manageUsersShow'])->name('show');

        Route::get('/{id}/edit', [AdminController::class, 'manageUsersEdit'])->name('edit');

        Route::put('/{id}', [AdminController::class, 'manageUsersUpdate'])->name('update');

        Route::delete('/{id}', [AdminController::class, 'manageUsersDestroy'])->name('destroy');
    });

});

// User
Route::prefix('user')->group(function () {
    Route::redirect('/dashboard', '/')->name('user.dashboard');
});

// Auth
Route::middleware('guest')->group(function () {
    // Tampilan Form Login & Register
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

    // Eksekusi Submit Form Login & Register
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::redirect('/home', '/');

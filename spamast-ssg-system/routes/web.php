<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventSessionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SanctionController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('landing-page'));

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    // All authenticated users can read announcements.
    Route::get('/announcements', [AnnouncementController::class, 'index'])
        ->name('announcements.index');

    // Officers and Advisers can view attendance records.
    Route::middleware('can:manage-records')->get(
        '/attendance',
        [AttendanceController::class, 'index']
    )->name('attendance.index');

    // Only Officers can manage attendance.
    Route::middleware('role:officer')->group(function () {
        Route::get('/attendance/create', [AttendanceController::class, 'create'])
            ->name('attendance.create');

        Route::post('/attendance', [AttendanceController::class, 'store'])
            ->name('attendance.store');

        Route::get('/attendance/{attendance}/edit', [AttendanceController::class, 'edit'])
            ->name('attendance.edit');

        Route::put('/attendance/{attendance}', [AttendanceController::class, 'update'])
            ->name('attendance.update');

        Route::patch('/attendance/{attendance}', [AttendanceController::class, 'update']);

        Route::delete('/attendance/{attendance}', [AttendanceController::class, 'destroy'])
            ->name('attendance.destroy');
    });

    // Officers and Advisers can manage records.
    Route::middleware('can:manage-records')->group(function () {

        Route::resource('sanctions', SanctionController::class)
            ->only(['index', 'create', 'store', 'edit', 'update']);

        Route::resource('events', EventController::class);

        // Announcement management, excluding the public-to-authenticated index.
        Route::resource('announcements', AnnouncementController::class)
            ->except(['index', 'show']);

        Route::post('/events/{event}/sessions', [EventSessionController::class, 'store'])
            ->name('events.sessions.store');

        Route::get('/events/{event}/sessions/{session}/edit', [EventSessionController::class, 'edit'])
            ->name('events.sessions.edit');

        Route::put('/events/{event}/sessions/{session}', [EventSessionController::class, 'update'])
            ->name('events.sessions.update');

        Route::delete('/events/{event}/sessions/{session}', [EventSessionController::class, 'destroy'])
            ->name('events.sessions.destroy');
    });

    Route::middleware('role:officer')->get(
        '/officer/dashboard',
        [DashboardController::class, 'officer']
    )->name('officer.dashboard');

    Route::middleware('role:adviser')->get(
        '/adviser/dashboard',
        [DashboardController::class, 'adviser']
    )->name('adviser.dashboard');

    Route::middleware('role:student')->get(
        '/student/dashboard',
        [DashboardController::class, 'student']
    )->name('student.dashboard');
});

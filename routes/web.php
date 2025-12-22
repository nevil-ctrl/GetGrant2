<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Middleware\CheckRole;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// -------------------------------
// API-хелперы для SPA (оставляем для совместимости)
// -------------------------------
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return response()->json(['success' => true]);
    });
Route::middleware(['web', 'auth:sanctum'])->group(function () {
    Route::get('/api/user', fn() => response()->json(Auth::user()));

    Route::post('/api/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return response()->json(['success' => true]);
    });
});

// -------------------------------
// Гостевые формы (Fortify)
// -------------------------------
Route::middleware(['web', 'guest'])->group(function () {
    // Явные страницы логина/регистрации (Blade формы)
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register.form');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

    Route::get('/auth/forgot-password', fn() => view('auth.forgot-password'))
        ->name('password.request');

    Route::post('/auth/forgot-password', [\Laravel\Fortify\Http\Controllers\PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('/auth/reset-password/{token}', function (\Illuminate\Http\Request $request, $token) {
        return view('auth.reset-password', ['request' => $request, 'token' => $token]);
    })->name('password.reset');

    Route::post('/auth/reset-password', [\Laravel\Fortify\Http\Controllers\NewPasswordController::class, 'store'])
        ->name('password.update');
});

// -------------------------------
// Публичные страницы (Blade)
// -------------------------------
Route::get('/', [PageController::class, 'home'])->name('pages.home');

Route::get('/countries', [PageController::class, 'countries'])->name('pages.countries');
Route::get('/countries/{country}', [PageController::class, 'country'])->name('pages.countries.show');

Route::get('/universities', [PageController::class, 'universities'])->name('pages.universities');
Route::get('/universities/{university}', [PageController::class, 'university'])->name('pages.universities.show');

Route::get('/programs', [PageController::class, 'programs'])->name('pages.programs');
Route::get('/programs/{program}', [PageController::class, 'program'])->name('pages.programs.show');

Route::get('/online-prep', [PageController::class, 'onlinePrep'])->name('pages.online-prep');

// -------------------------------
// Дашборды по ролям (Blade)
// -------------------------------
Route::middleware(['web', 'auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        return match ($user->role) {
            'student' => redirect()->route('student.dashboard'),
            'parent' => redirect()->route('parent.dashboard'),
            'manager' => redirect()->route('manager.dashboard'),
            'admin' => redirect('/admin'),
            default => redirect('/'),
        };
    })->name('dashboard.redirect');

    Route::get('/student-dashboard', [DashboardController::class, 'student'])
        ->middleware([CheckRole::class . ':student'])
        ->name('student.dashboard');

    Route::get('/parent-dashboard', [DashboardController::class, 'parent'])
        ->middleware([CheckRole::class . ':parent'])
        ->name('parent.dashboard');

    Route::get('/manager-dashboard', [DashboardController::class, 'manager'])
        ->middleware([CheckRole::class . ':manager'])
        ->name('manager.dashboard');

    Route::get('/admin-dashboard', fn() => view('dashboards.admin'))
        ->middleware([CheckRole::class . ':admin'])
        ->name('admin.dashboard');
});

// Редирект /home → /dashboard
Route::redirect('/home', '/dashboard');

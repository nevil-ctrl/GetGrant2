<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

// -------------------------------
// API-хелперы для SPA (оставляем для совместимости)
// -------------------------------
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return response()->json(['success' => true]);
})->name('logout');
Route::middleware(['web', 'auth:sanctum'])->group(function () {
    Route::get('/api/user', fn () => response()->json(Auth::user()));

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

    Route::get('/auth/forgot-password', fn () => view('auth.forgot-password'))
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
Route::get('/countries/{code}', [PageController::class, 'country'])->name('pages.countries.show');

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
            'student' => redirect()->route('dashboard'),
            'parent' => redirect()->route('dashboard'),
            'manager' => redirect()->route('dashboard'),
            'admin' => redirect('/admin'),
            default => redirect('/'),
        };
    })->name('dashboard.redirect');

    // Единый дашборд для всех ролей (студент, родитель, менеджер)
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware([CheckRole::class.':student,parent,manager'])
        ->name('dashboard');

    Route::get('/admin-dashboard', fn () => view('dashboards.admin'))
        ->middleware([CheckRole::class.':admin'])
        ->name('admin.dashboard');

    // LMS Routes - Lessons
    Route::resource('lessons', \App\Http\Controllers\LessonController::class);
    Route::get('/lessons/{lesson}/assignments', [\App\Http\Controllers\LessonController::class, 'assignments'])
        ->name('lessons.assignments');

    // LMS Routes - Assignments
    Route::resource('assignments', \App\Http\Controllers\AssignmentController::class);
    Route::post('/assignments/{assignment}/submit', [\App\Http\Controllers\AssignmentController::class, 'submit'])
        ->name('assignments.submit');
    Route::get('/assignments/{assignment}/review', [\App\Http\Controllers\AssignmentController::class, 'review'])
        ->name('assignments.review');
    Route::post('/assignments/{assignment}/review', [\App\Http\Controllers\AssignmentController::class, 'reviewStore'])
        ->name('assignments.review.store');

    // LMS Routes - Categories (only for managers and admins)
    Route::resource('categories', \App\Http\Controllers\CategoryController::class)
        ->middleware([CheckRole::class.':manager,admin']);

    // LMS Routes - Buildings (only for managers and admins)
    Route::resource('buildings', \App\Http\Controllers\BuildingController::class)
        ->middleware([CheckRole::class.':manager,admin']);

    // LMS Routes - Enrollments (only for managers and admins)
    Route::resource('enrollments', \App\Http\Controllers\EnrollmentController::class)
        ->middleware([CheckRole::class.':manager,admin']);
    Route::post('/enrollments/bulk-update', [\App\Http\Controllers\EnrollmentController::class, 'bulkUpdate'])
        ->middleware([CheckRole::class.':manager,admin'])
        ->name('enrollments.bulk-update');
});

// Редирект /home → /dashboard
Route::redirect('/home', '/dashboard');

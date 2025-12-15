<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login; // ✅ ИСПРАВЛЕНО

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request)
            {
                // Для React SPA возвращаем JSON вместо редиректа
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Logged out successfully']);
                }

                // Для Blade - редирект
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                Auth::logout();

                return redirect('/?logout=' . time());
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Views для аутентификации
        Fortify::loginView(fn() => view('auth.login'));
        Fortify::registerView(fn() => view('auth.register'));
        // Views для сброса пароля (Blade шаблоны)
        Fortify::requestPasswordResetLinkView(fn() => view('auth.forgot-password'));
        Fortify::resetPasswordView(fn($request) => view('auth.reset-password', ['request' => $request]));
        Fortify::verifyEmailView(fn() => view('auth.verify-email'));

        // Actions
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        // Кастомная аутентификация
        Fortify::authenticateUsing(function (Request $request) {
            $user = \App\Models\User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                Auth::login($user);
                return $user;
            }

            return null;
        });

        // Rate limiting
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());
            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // ✅ ИСПРАВЛЕНО: Используем правильное событие
        Event::listen(Login::class, function ($event) {
            $user = $event->user;

            // Для API запросов не делаем редирект
            if (request()->expectsJson()) {
                return;
            }

            // Для Blade - редирект по роли
            $route = match ($user->profile_type) {
                'student' => '/student-dashboard',
                'parent' => '/parent-dashboard',
                'manager' => '/manager-dashboard',
                'admin' => '/admin-dashboard',
                default => '/dashboard',
            };

            session()->put('url.intended', $route);
        });
    }
}
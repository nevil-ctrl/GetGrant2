<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Auth\Events\Login;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->instance(
            \Laravel\Fortify\Contracts\LogoutResponse::class,
            new class implements \Laravel\Fortify\Contracts\LogoutResponse
            {
                public function toResponse($request)
                {
                    if ($request->expectsJson()) {
                        return response()->json(['message' => 'Logged out successfully']);
                    }

                    return redirect()->route('pages.home');
                }
            }
        );
    }

    public function boot(): void
    {
        // ❌ НЕ регистрируем Auth::routes() нигде
        // ✅ Только Fortify

        // Views
        Fortify::loginView(fn () => view('auth.login'));
        Fortify::registerView(fn () => view('auth.register'));
        Fortify::requestPasswordResetLinkView(fn () => view('auth.forgot-password'));
        Fortify::resetPasswordView(fn ($request) => view('auth.reset-password', ['request' => $request]));
        Fortify::verifyEmailView(fn () => view('auth.verify-email'));

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
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for(
            'two-factor',
            fn (Request $request) => Limit::perMinute(5)->by($request->session()->get('login.id'))
        );

        // Редирект по роли
        Event::listen(Login::class, function ($event) {
            $user = $event->user;

            if (request()->expectsJson()) {
                return;
            }

            $route = match ($user->role) {
                'student', 'parent', 'manager' => '/dashboard',
                'admin' => '/admin',
                default => '/dashboard',
            };

            session()->put('url.intended', $route);
        });

        // ❌ ВАЖНО: отключаем Fortify маршруты для Blade, если дублируются
        // если используешь кастомные blade-шаблоны, это не нужно
        Fortify::ignoreRoutes();
    }
}

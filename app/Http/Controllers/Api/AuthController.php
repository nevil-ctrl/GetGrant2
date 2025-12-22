<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique(User::class, 'email')],
            'phone' => ['nullable', 'string', 'max:32'],
            'phone_unvalidated' => ['nullable', 'in:0,1'],
            'profile_type' => ['nullable', Rule::in(['student', 'parent'])],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()],
        ]);

        // Определяем роль и profile_type синхронно
        $profileType = $validated['profile_type'] ?? 'student';
        $role = $profileType; // role всегда равен profile_type для обычных пользователей
        
        $phone = $validated['phone'] ?? null;
        $phoneValidated = !empty($phone) && empty($validated['phone_unvalidated']);

        // Серверная попытка нормализации через libphonenumber (если доступна) — помечаем номер валидным, если парсинг прошёл
        $phoneCountry = $validated['phone_country'] ?? null;
        if (!empty($phone) && class_exists('\libphonenumber\PhoneNumberUtil')) {
            try {
                $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
                $proto = $phoneUtil->parse($phone, strtoupper($phoneCountry ?? ''));
                if ($phoneUtil->isPossibleNumber($proto) || $phoneUtil->isValidNumber($proto)) {
                    $phone = $phoneUtil->format($proto, \libphonenumber\PhoneNumberFormat::E164);
                    $phoneValidated = true;
                }
            } catch (\libphonenumber\NumberParseException $e) {
                // ignore
            }
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $phone,
            'phone_validated' => $phoneValidated,
            'profile_type' => $profileType,
            'role' => $role,
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json($user, 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['sometimes', 'boolean'],
        ]);

        $remember = $credentials['remember'] ?? false;

        if (! Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            throw ValidationException::withMessages([
                'email' => __('Неверные учетные данные.'),
            ]);
        }

        $request->session()->regenerate();

        return response()->json(Auth::user());
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Вы вышли из системы']);
    }
}

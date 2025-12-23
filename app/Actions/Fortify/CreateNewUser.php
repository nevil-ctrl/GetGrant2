<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => $this->passwordRules(),
            'phone' => ['nullable', 'string', 'max:20'],
            'phone_unvalidated' => ['nullable', 'in:0,1'],
            'profile_type' => ['nullable', 'in:student,parent'],
            'manager_id' => ['nullable', 'exists:users,id'],
        ])->validate();

        $phone = $input['phone'] ?? null;
        $phoneValidated = ! empty($phone) && empty($input['phone_unvalidated']);

        // Попытка нормализовать номер на сервере, если доступна библиотека libphonenumber
        $phoneCountry = $input['phone_country'] ?? null;
        if (! empty($phone) && class_exists('\libphonenumber\PhoneNumberUtil')) {
            try {
                $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
                $proto = $phoneUtil->parse($phone, strtoupper($phoneCountry ?? ''));
                if ($phoneUtil->isPossibleNumber($proto) || $phoneUtil->isValidNumber($proto)) {
                    $phone = $phoneUtil->format($proto, \libphonenumber\PhoneNumberFormat::E164);
                    // Если парсинг успешен — считаем номер валидным
                    $phoneValidated = true;
                }
            } catch (\libphonenumber\NumberParseException $e) {
                // оставляем как есть
            }
        }

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'phone' => $phone,
            'phone_validated' => $phoneValidated,
            'profile_type' => $input['profile_type'] ?? 'student',
            'role' => $input['profile_type'] ?? 'student',
            'manager_id' => $input['manager_id'] ?? null,
        ]);
    }
}

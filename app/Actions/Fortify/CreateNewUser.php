<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     */
    public function create(array $input): User
    {
        // Валидируем только поля, разрешённые для обычной регистрации
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => $this->passwordRules(),
            'profile_type' => ['required', 'in:student,parent'],
        ])->validate();

        $profileType = $input['profile_type'] ?? 'student';
        
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => $profileType, // role = profile_type для регистрации
            'profile_type' => $profileType,
        ]);

        // Автоматическое назначение менеджера для студентов и родителей
        if (in_array($profileType, ['student', 'parent'])) {
            $manager = User::where('role', 'manager')
                ->whereHas('managedStudents', function ($query) {
                    $query->selectRaw('manager_id, COUNT(*) as count')
                        ->groupBy('manager_id')
                        ->havingRaw('COUNT(*) < 50'); // Максимум 50 студентов на менеджера
                })
                ->orWhereDoesntHave('managedStudents')
                ->first();
            
            if ($manager) {
                $user->update(['manager_id' => $manager->id]);
            }
        }

        return $user;
    }
}

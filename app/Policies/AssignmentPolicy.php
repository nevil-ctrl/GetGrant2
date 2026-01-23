<?php

namespace App\Policies;

use App\Models\Assignment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AssignmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Assignment $assignment): bool
    {
        // Студенты могут видеть только свои задания
        if ($user->role === 'student') {
            return $assignment->user_id === $user->id;
        }
        // Менеджеры и админы могут видеть задания к своим урокам
        return $user->role === 'admin' || $assignment->lesson->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['manager', 'admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Assignment $assignment): bool
    {
        // Студенты могут обновлять только свои задания (отправлять ссылку)
        if ($user->role === 'student') {
            return $assignment->user_id === $user->id && $assignment->status === 'pending';
        }
        // Учителя и админы могут обновлять задания к своим урокам
        return $user->role === 'admin' || $assignment->lesson->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Assignment $assignment): bool
    {
        return $user->role === 'admin' || $assignment->lesson->user_id === $user->id;
    }

    /**
     * Determine whether the user can review the assignment.
     */
    public function review(User $user, Assignment $assignment): bool
    {
        return $user->role === 'admin' || $assignment->lesson->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Assignment $assignment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Assignment $assignment): bool
    {
        return false;
    }
}

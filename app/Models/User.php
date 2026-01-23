<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_type',
        'role',
        'manager_id',
        'student_id', // Для родителей: связь с их ребенком
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === 'admin';
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(self::class, 'manager_id');
    }

    public function managedStudents(): HasMany
    {
        return $this->hasMany(self::class, 'manager_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function createdLessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'user_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(self::class, 'student_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'student_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'student_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function isParent(): bool
    {
        return $this->role === 'parent';
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function enrolledLessons()
    {
        return $this->belongsToMany(Lesson::class, 'enrollments')
            ->withPivot('status')
            ->withTimestamps();
    }
}

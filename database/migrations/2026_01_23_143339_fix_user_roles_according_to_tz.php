<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Обновляем роли: убираем teacher, добавляем parent и manager
        if (DB::getPdo() && DB::getPdo()->getAttribute(\PDO::ATTR_DRIVER_NAME) === 'pgsql') {
            // Удаляем старые constraints
            DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check;');
            DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_profile_type_check;');
            
            // Создаем новые constraints с правильными ролями
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('student','parent','manager','admin'));");
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_profile_type_check CHECK (profile_type IN ('student','parent'));");
            
            // Обновляем существующих teacher на manager
            DB::table('users')
                ->where('role', 'teacher')
                ->orWhere('profile_type', 'teacher')
                ->update([
                    'role' => 'manager',
                    'profile_type' => DB::raw("CASE WHEN profile_type = 'teacher' THEN 'student' ELSE profile_type END")
                ]);
        } else {
            // Для MySQL/SQLite просто изменяем enum
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['student', 'parent', 'manager', 'admin'])
                    ->default('student')
                    ->change();
                $table->enum('profile_type', ['student', 'parent'])
                    ->default('student')
                    ->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getPdo() && DB::getPdo()->getAttribute(\PDO::ATTR_DRIVER_NAME) === 'pgsql') {
            DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check;');
            DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_profile_type_check;');
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('student','teacher','admin'));");
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_profile_type_check CHECK (profile_type IN ('student','teacher','admin'));");
        }
    }
};

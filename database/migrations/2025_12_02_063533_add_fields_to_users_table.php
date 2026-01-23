<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Роли согласно ТЗ: student, parent, manager, admin
            $table->enum('role', ['student', 'parent', 'manager', 'admin'])->default('student');
            
            // Тип профиля для регистрации: только student или parent
            $table->enum('profile_type', ['student', 'parent'])->default('student');
            
            // Менеджер назначается автоматически после регистрации
            $table->unsignedBigInteger('manager_id')->nullable()->after('profile_type');
            $table->foreign('manager_id')->references('id')->on('users')->nullOnDelete();
            
            // Для родителей: связь с их ребенком-студентом
            $table->unsignedBigInteger('student_id')->nullable()->after('manager_id');
            $table->foreign('student_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
            $table->dropColumn(['role', 'profile_type', 'manager_id']);
        });
    }
};

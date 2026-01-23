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
        // Индексы для таблицы users
        Schema::table('users', function (Blueprint $table) {
            try {
                $table->index('role', 'users_role_index');
            } catch (\Exception $e) {
                // Индекс уже существует
            }
            try {
                $table->index('email', 'users_email_index');
            } catch (\Exception $e) {
                // Индекс уже существует
            }
            try {
                $table->index('manager_id', 'users_manager_id_index');
            } catch (\Exception $e) {
                // Индекс уже существует
            }
        });

        // Индексы для таблицы lessons
        Schema::table('lessons', function (Blueprint $table) {
            try {
                $table->index('user_id', 'lessons_user_id_index');
                $table->index('course_id', 'lessons_course_id_index');
                $table->index('category_id', 'lessons_category_id_index');
                $table->index('is_published', 'lessons_is_published_index');
                $table->index(['is_published', 'category_id'], 'lessons_published_category_index');
            } catch (\Exception $e) {
                // Индексы уже существуют
            }
        });

        // Индексы для таблицы assignments
        Schema::table('assignments', function (Blueprint $table) {
            try {
                $table->index('user_id', 'assignments_user_id_index');
                $table->index('lesson_id', 'assignments_lesson_id_index');
                $table->index('status', 'assignments_status_index');
                $table->index(['user_id', 'status'], 'assignments_user_status_index');
            } catch (\Exception $e) {
                // Индексы уже существуют
            }
        });

        // Индексы для таблицы courses
        Schema::table('courses', function (Blueprint $table) {
            try {
                $table->index('is_active', 'courses_is_active_index');
            } catch (\Exception $e) {
                // Индекс уже существует
            }
        });

        // Индексы для таблицы categories
        Schema::table('categories', function (Blueprint $table) {
            try {
                $table->index('is_active', 'categories_is_active_index');
                $table->index('slug', 'categories_slug_index');
            } catch (\Exception $e) {
                // Индексы уже существуют
            }
        });

        // Индексы для таблицы countries
        Schema::table('countries', function (Blueprint $table) {
            try {
                $table->index('is_active', 'countries_is_active_index');
            } catch (\Exception $e) {
                // Индекс уже существует
            }
        });

        // Индексы для таблицы universities
        Schema::table('universities', function (Blueprint $table) {
            try {
                $table->index('country_id', 'universities_country_id_index');
                $table->index('is_active', 'universities_is_active_index');
            } catch (\Exception $e) {
                // Индексы уже существуют
            }
        });

        // Индексы для таблицы programs
        Schema::table('programs', function (Blueprint $table) {
            try {
                $table->index('university_id', 'programs_university_id_index');
                $table->index('is_active', 'programs_is_active_index');
            } catch (\Exception $e) {
                // Индексы уже существуют
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_role_index');
            $table->dropIndex('users_email_index');
            $table->dropIndex('users_manager_id_index');
        });

        Schema::table('lessons', function (Blueprint $table) {
            $table->dropIndex('lessons_user_id_index');
            $table->dropIndex('lessons_course_id_index');
            $table->dropIndex('lessons_category_id_index');
            $table->dropIndex('lessons_is_published_index');
            $table->dropIndex('lessons_published_category_index');
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->dropIndex('assignments_user_id_index');
            $table->dropIndex('assignments_lesson_id_index');
            $table->dropIndex('assignments_status_index');
            $table->dropIndex('assignments_user_status_index');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropIndex('courses_is_active_index');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('categories_is_active_index');
            $table->dropIndex('categories_slug_index');
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->dropIndex('countries_is_active_index');
        });

        Schema::table('universities', function (Blueprint $table) {
            $table->dropIndex('universities_country_id_index');
            $table->dropIndex('universities_is_active_index');
        });

        Schema::table('programs', function (Blueprint $table) {
            $table->dropIndex('programs_university_id_index');
            $table->dropIndex('programs_is_active_index');
        });
    }

};

<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /**
     * Единый дашборд для всех ролей (student, parent, manager)
     */
    public function index(Request $request)
    {
        $user = $request->user()->load(['manager', 'student', 'children']);

        // Данные для студента
        if ($user->isStudent()) {
            return $this->studentDashboard($user);
        }

        // Данные для родителя
        if ($user->isParent()) {
            return $this->parentDashboard($user);
        }

        // Данные для менеджера
        if ($user->isManager()) {
            return $this->managerDashboard($user);
        }

        abort(403, 'Доступ запрещён');
    }

    /**
     * Дашборд для студента
     */
    private function studentDashboard($user)
    {
        // Загружаем курсы с опубликованными уроками (с кешированием)
        $courses = Cache::remember('student_courses', 3600, function () {
            return \App\Models\Course::where('is_active', true)
                ->with(['lessons' => function ($query) {
                    $query->where('is_published', true)
                        ->with('category')
                        ->orderBy('order');
                }])
                ->get();
        });

        // Загружаем категории с уроками (с кешированием)
        $categories = Cache::remember('student_categories', 3600, function () {
            return \App\Models\Category::where('is_active', true)
                ->with(['lessons' => function ($query) {
                    $query->where('is_published', true)
                        ->with('course')
                        ->orderBy('order');
                }])
                ->get();
        });

        // Загружаем задания студента
        $assignments = \App\Models\Assignment::where('user_id', $user->id)
            ->with(['lesson.course', 'lesson.category'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Загружаем последние просмотренные уроки
        $recentLessons = \App\Models\Lesson::where('is_published', true)
            ->with(['course', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Загружаем заявку на поступление
        $application = Application::where('user_id', $user->id)
            ->latest()
            ->first();

        return view('dashboards.index', [
            'user' => $user,
            'role' => 'student',
            'courses' => $courses,
            'categories' => $categories,
            'assignments' => $assignments,
            'recentLessons' => $recentLessons,
            'application' => $application,
        ]);
    }

    /**
     * Дашборд для родителя
     */
    private function parentDashboard($user)
    {
        // Родитель видит данные своего ребенка
        $student = $user->student;
        
        if (!$student) {
            // Если ребенок не привязан, показываем сообщение
            return view('dashboards.index', [
                'user' => $user,
                'role' => 'parent',
                'student' => null,
            ]);
        }

        // Загружаем данные ребенка
        $application = Application::where('user_id', $student->id)
            ->latest()
            ->first();

        $assignments = \App\Models\Assignment::where('user_id', $student->id)
            ->with(['lesson.course', 'lesson.category'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboards.index', [
            'user' => $user,
            'role' => 'parent',
            'student' => $student,
            'application' => $application,
            'assignments' => $assignments,
        ]);
    }

    /**
     * Дашборд для менеджера
     */
    private function managerDashboard($user)
    {
        // Загружаем студентов менеджера
        $students = $user->managedStudents()
            ->with(['applications', 'assignments'])
            ->get();

        // Загружаем курсы и уроки, созданные менеджером
        $courses = \App\Models\Course::whereHas('lessons', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with(['lessons' => function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->with('category')
                ->orderBy('order');
        }])
        ->get();

        // Загружаем категории менеджера
        $categories = \App\Models\Category::where('is_active', true)
            ->with(['lessons' => function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orderBy('order');
            }])
            ->get();

        // Задания на проверку
        $pendingAssignments = \App\Models\Assignment::whereHas('lesson', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('status', 'submitted')
        ->with(['user', 'lesson'])
        ->orderBy('submitted_at', 'desc')
        ->get();

        return view('dashboards.index', [
            'user' => $user,
            'role' => 'manager',
            'students' => $students,
            'courses' => $courses,
            'categories' => $categories,
            'pendingAssignments' => $pendingAssignments,
        ]);
    }
}

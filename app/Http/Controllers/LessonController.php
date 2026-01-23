<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class LessonController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isStudent()) {
            $lessons = Lesson::where('is_published', true)
                ->with(['course', 'category'])
                ->orderBy('order')
                ->get();
        } elseif ($user->isManager() || $user->isAdmin()) {
            $lessons = Lesson::where('user_id', $user->id)
                ->with(['course', 'category'])
                ->orderBy('order')
                ->get();
        } else {
            $lessons = collect();
        }

        return view('lessons.index', compact('lessons'));
    }

    public function create()
    {
        $this->authorize('create', Lesson::class);
        
        $courses = Course::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();

        return view('lessons.create', compact('courses', 'categories'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Lesson::class);

        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'video_url' => ['nullable', 'url'],
            'video_thumbnail' => ['nullable', 'url'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_published'] = $validated['is_published'] ?? false;

        $lesson = Lesson::create($validated);

        // Перенаправляем на дашборд с вкладкой уроков
        return redirect()->route('dashboard')->with('success', 'Урок успешно создан')
            ->with('active_tab', 'lessons');
    }

    public function show(Lesson $lesson)
    {
        $user = Auth::user();
        
        // Студенты могут видеть только опубликованные уроки
        if ($user->isStudent() && !$lesson->is_published) {
            abort(404);
        }

        // Загружаем все задания для урока (студенты видят свои, менеджеры - все)
        $lesson->load(['course', 'category']);
        
        if ($user->isStudent()) {
            $lesson->load(['assignments' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }]);
        } else {
            $lesson->load('assignments');
        }

        return view('lessons.show', compact('lesson'));
    }

    public function edit(Lesson $lesson)
    {
        $this->authorize('update', $lesson);

        $courses = Course::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();

        return view('lessons.edit', compact('lesson', 'courses', 'categories'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $this->authorize('update', $lesson);

        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'language' => ['required', 'in:ru,en'],
            'video_url' => ['nullable', 'url'],
            'video_thumbnail' => ['nullable', 'url'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $lesson->update($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Урок успешно обновлён')
            ->with('active_tab', 'lessons');
    }

    public function destroy(Lesson $lesson)
    {
        $this->authorize('delete', $lesson);

        $lesson->delete();

        return redirect()->route('lessons.index')
            ->with('success', 'Урок успешно удалён');
    }

    public function assignments(Lesson $lesson)
    {
        $this->authorize('view', $lesson);

        $assignments = $lesson->assignments()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('lessons.assignments', compact('lesson', 'assignments'));
    }
}

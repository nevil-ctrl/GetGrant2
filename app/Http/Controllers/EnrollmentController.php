<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\User;
use App\Models\Lesson;
use App\Http\Middleware\CheckRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(CheckRole::class.':manager,admin');
    }

    public function index(Request $request)
    {
        $query = Enrollment::with(['user', 'lesson']);

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->get('user_id'));
        }

        if ($request->filled('lesson_id')) {
            $query->where('lesson_id', $request->get('lesson_id'));
        }

        $enrollments = $query->orderBy('created_at', 'desc')->paginate(20);
        $students = User::where('role', 'student')->get();
        $lessons = Lesson::where('user_id', Auth::id())->get();

        return view('enrollments.index', compact('enrollments', 'students', 'lessons'));
    }

    public function create()
    {
        $students = User::where('role', 'student')->get();
        $lessons = Lesson::where('user_id', Auth::id())->get();
        return view('enrollments.create', compact('students', 'lessons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'lesson_id' => ['required', 'exists:lessons,id'],
            'status' => ['required', 'in:enrolled,foreign,beginner,applied_abroad,started,finished,inactive'],
        ]);

        Enrollment::updateOrCreate(
            [
                'user_id' => $validated['user_id'],
                'lesson_id' => $validated['lesson_id'],
            ],
            ['status' => $validated['status']]
        );

        return redirect()->route('enrollments.index')
            ->with('success', 'Запись успешно создана');
    }

    public function show(Enrollment $enrollment)
    {
        $enrollment->load(['user', 'lesson']);
        return view('enrollments.show', compact('enrollment'));
    }

    public function edit(Enrollment $enrollment)
    {
        $students = User::where('role', 'student')->get();
        $lessons = Lesson::where('user_id', Auth::id())->get();
        return view('enrollments.edit', compact('enrollment', 'students', 'lessons'));
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:enrolled,foreign,beginner,applied_abroad,started,finished,inactive'],
        ]);

        $enrollment->update($validated);

        return redirect()->route('enrollments.index')
            ->with('success', 'Статус успешно обновлен');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return redirect()->route('enrollments.index')
            ->with('success', 'Запись успешно удалена');
    }

    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'enrollment_ids' => ['required', 'array'],
            'enrollment_ids.*' => ['exists:enrollments,id'],
            'status' => ['required', 'in:enrolled,foreign,beginner,applied_abroad,started,finished,inactive'],
        ]);

        Enrollment::whereIn('id', $validated['enrollment_ids'])
            ->update(['status' => $validated['status']]);

        return redirect()->back()
            ->with('success', 'Статусы успешно обновлены');
    }
}

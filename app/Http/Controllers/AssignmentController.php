<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Lesson;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isStudent()) {
            $assignments = Assignment::where('user_id', $user->id)
                ->with(['lesson.course', 'lesson.category', 'building'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Для менеджеров и админов показываем все задания их уроков
            $assignments = Assignment::whereHas('lesson', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['user', 'lesson.course', 'lesson.category', 'building'])
            ->orderBy('created_at', 'desc')
            ->get();
        }

        return view('assignments.index', compact('assignments'));
    }

    public function create()
    {
        $this->authorize('create', Assignment::class);

        $user = Auth::user();
        $lessons = Lesson::where('user_id', $user->id)
            ->where('is_published', true)
            ->with('course')
            ->get();
        $buildings = Building::all();

        return view('assignments.create', compact('lessons', 'buildings'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Assignment::class);

        $validated = $request->validate([
            'lesson_id' => ['required', 'exists:lessons,id'],
            'building_id' => ['nullable', 'exists:buildings,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date' => ['nullable', 'date', 'after:today'],
            'files' => ['nullable', 'array'],
            'images' => ['nullable', 'array'],
        ]);

        $assignment = Assignment::create($validated);

        return redirect()->route('lessons.assignments', $assignment->lesson)
            ->with('success', 'Задание успешно создано');
    }

    public function show(Assignment $assignment)
    {
        $this->authorize('view', $assignment);

        $assignment->load(['lesson.course', 'lesson.category', 'user', 'building']);

        return view('assignments.show', compact('assignment'));
    }

    public function edit(Assignment $assignment)
    {
        $this->authorize('update', $assignment);

        $user = Auth::user();
        $lessons = Lesson::where('user_id', $user->id)
            ->where('is_published', true)
            ->with('course')
            ->get();
        $buildings = Building::all();

        return view('assignments.edit', compact('assignment', 'lessons', 'buildings'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $this->authorize('update', $assignment);

        $validated = $request->validate([
            'building_id' => ['nullable', 'exists:buildings,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date' => ['nullable', 'date'],
            'files' => ['nullable', 'array'],
            'images' => ['nullable', 'array'],
        ]);

        $assignment->update($validated);

        return redirect()->route('assignments.show', $assignment)
            ->with('success', 'Задание успешно обновлено');
    }

    public function destroy(Assignment $assignment)
    {
        $this->authorize('delete', $assignment);

        $assignment->delete();

        return redirect()->back()
            ->with('success', 'Задание успешно удалено');
    }

    public function submit(Request $request, Assignment $assignment)
    {
        $this->authorize('update', $assignment);

        $validated = $request->validate([
            'submission_link' => ['required', 'url', 'max:500'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $assignment->update([
            'submission_link' => $validated['submission_link'],
            'student_comment' => $validated['comment'] ?? null,
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Задание успешно отправлено на проверку');
    }

    public function review(Assignment $assignment)
    {
        $this->authorize('review', $assignment);

        $assignment->load(['user', 'lesson']);

        return view('assignments.review', compact('assignment'));
    }

    public function reviewStore(Request $request, Assignment $assignment)
    {
        $this->authorize('review', $assignment);

        $validated = $request->validate([
            'status' => ['required', 'in:approved,rejected'],
            'teacher_comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $assignment->update([
            'status' => $validated['status'],
            'teacher_comment' => $validated['teacher_comment'] ?? null,
            'reviewed_at' => now(),
        ]);

        return redirect()->route('assignments.show', $assignment)
            ->with('success', 'Задание проверено');
    }
}

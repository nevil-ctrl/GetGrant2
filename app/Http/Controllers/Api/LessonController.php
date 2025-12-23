<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index()
    {
        return Lesson::with('course', 'user')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
            'scheduled_at' => 'required|date',
            'duration' => 'nullable|integer|min:1',
            'meeting_link' => 'nullable|string|max:255',
            'status' => 'nullable|in:scheduled,completed,cancelled',
        ]);

        return Lesson::create($validated);
    }

    public function show(string $id)
    {
        return Lesson::with('course', 'user')->findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $lesson = Lesson::findOrFail($id);

        $validated = $request->validate([
            'course_id' => 'sometimes|exists:courses,id',
            'user_id' => 'sometimes|exists:users,id',
            'scheduled_at' => 'sometimes|date',
            'duration' => 'nullable|integer|min:1',
            'meeting_link' => 'nullable|string|max:255',
            'status' => 'nullable|in:scheduled,completed,cancelled',
        ]);

        $lesson->update($validated);

        return $lesson;
    }

    public function destroy(string $id)
    {
        return Lesson::destroy($id);
    }
}

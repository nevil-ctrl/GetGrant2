<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return Course::with('lessons')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:english,ielts,sat,career',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        return Course::create($validated);
    }

    public function show(string $id)
    {
        return Course::with('lessons')->findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|string|in:english,ielts,sat,career',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $course->update($validated);

        return $course;
    }

    public function destroy(string $id)
    {
        return Course::destroy($id);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApplicationStep;
use Illuminate\Http\Request;

class ApplicationStepController extends Controller
{
    public function index()
    {
        return ApplicationStep::with('application')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'application_id' => 'required|exists:applications,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,completed',
            'completed_at' => 'nullable|date',
        ]);

        return ApplicationStep::create($validated);
    }

    public function show(string $id)
    {
        return ApplicationStep::with('application')->findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $step = ApplicationStep::findOrFail($id);

        $validated = $request->validate([
            'application_id' => 'sometimes|exists:applications,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,completed',
            'completed_at' => 'nullable|date',
        ]);

        $step->update($validated);

        return $step;
    }

    public function destroy(string $id)
    {
        return ApplicationStep::destroy($id);
    }
}

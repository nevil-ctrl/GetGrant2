<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        return Lead::with(['user', 'manager'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'manager_id' => 'nullable|exists:users,id',
            'status' => 'nullable|in:new,contacted,consultation,closed',
            'source' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        return Lead::create($validated);
    }

    public function show(string $id)
    {
        return Lead::with(['user', 'manager'])->findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $lead = Lead::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'manager_id' => 'sometimes|exists:users,id',
            'status' => 'nullable|in:new,contacted,consultation,closed',
            'source' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $lead->update($validated);

        return $lead;
    }

    public function destroy(string $id)
    {
        return Lead::destroy($id);
    }
}

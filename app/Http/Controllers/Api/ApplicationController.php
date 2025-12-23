<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = Application::all();

        return response()->json($applications, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'university_id' => 'nullable|exists:universities,id',
            'program_id' => 'nullable|exists:programs,id',
            'status' => 'nullable|in:consultation,documents,submission,offer,visa,departure',
            'timeline' => 'nullable|json',
            'notes' => 'nullable|string',
        ]);

        $application = Application::create($data);

        return response()->json($application, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        return response()->json($application, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        $data = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'university_id' => 'nullable|exists:universities,id',
            'program_id' => 'nullable|exists:programs,id',
            'status' => 'nullable|in:consultation,documents,submission,offer,visa,departure',
            'timeline' => 'nullable|json',
            'notes' => 'nullable|string',
        ]);

        $application->update($data);

        return response()->json($application, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        $application->delete();

        return response()->json(null, 204);
    }
}

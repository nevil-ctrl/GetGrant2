<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\University;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    /**
     * Список университетов.
     * GET /api/universities
     */
    public function index(Request $request): JsonResponse
    {
        $query = University::query()->where('is_active', true);

        if ($countryId = $request->get('country_id')) {
            $query->where('country_id', $countryId);
        }

        if ($search = $request->get('search')) {
            $query->where('name', 'like', '%'.$search.'%');
        }

        $universities = $query->paginate(20);

        return response()->json($universities);
    }

    /**
     * Создание университета.
     * POST /api/universities
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'description' => ['nullable', 'string'],
            'logo' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'cost_min' => ['nullable', 'numeric', 'min:0'],
            'cost_max' => ['nullable', 'numeric', 'min:0'],
            'requirements' => ['nullable'], // можно уточнить формат (array/json)
            'deadlines' => ['nullable'], // можно уточнить формат (array/json)
            'level' => ['nullable', 'string', 'max:50'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $university = University::create($data);

        return response()->json($university, 201);
    }

    /**
     * Университет с программами.
     * GET /api/universities/{id}
     */
    public function show(int $id): JsonResponse
    {
        $university = University::with([
            'programs' => function ($query) {
                $query->where('is_active', true);
            },
        ])->findOrFail($id);

        return response()->json($university);
    }

    /**
     * Обновление университета.
     * PUT/PATCH /api/universities/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $university = University::findOrFail($id);

        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'country_id' => ['sometimes', 'integer', 'exists:countries,id'],
            'description' => ['nullable', 'string'],
            'logo' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'cost_min' => ['nullable', 'numeric', 'min:0'],
            'cost_max' => ['nullable', 'numeric', 'min:0'],
            'requirements' => ['nullable'],
            'deadlines' => ['nullable'],
            'level' => ['nullable', 'string', 'max:50'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $university->update($data);

        return response()->json($university);
    }

    /**
     * Удаление университета.
     * DELETE /api/universities/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $university = University::findOrFail($id);
        $university->delete();

        return response()->json(['message' => 'University deleted successfully']);
    }
}

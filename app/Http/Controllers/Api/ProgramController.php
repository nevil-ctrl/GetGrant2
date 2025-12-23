<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Список программ.
     * GET /api/programs
     */
    public function index(Request $request): JsonResponse
    {
        $query = Program::query()->where('is_active', true);

        if ($universityId = $request->get('university_id')) {
            $query->where('university_id', $universityId);
        }

        if ($countryId = $request->get('country_id')) {
            $query->whereHas('university.country', function ($q) use ($countryId) {
                $q->where('id', $countryId);
            });
        }

        if ($field = $request->get('field_of_study')) {
            $query->where('field_of_study', $field);
        }

        $programs = $query->paginate(20);

        return response()->json($programs);
    }

    /**
     * Создание программы.
     * POST /api/programs
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'university_id' => ['required', 'integer', 'exists:universities,id'],
            'description' => ['nullable', 'string'],
            'field_of_study' => ['nullable', 'string', 'max:255'],
            'is_top' => ['sometimes', 'boolean'],
            'career_info' => ['nullable'], // можно уточнить формат (array/json)
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $program = Program::create($data);

        return response()->json($program, 201);
    }

    /**
     * Детальная информация о программе.
     * GET /api/programs/{id}
     */
    public function show(int $id): JsonResponse
    {
        $program = Program::with(['university.country'])->findOrFail($id);

        return response()->json($program);
    }

    /**
     * Обновление программы.
     * PUT/PATCH /api/programs/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $program = Program::findOrFail($id);

        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'university_id' => ['sometimes', 'integer', 'exists:universities,id'],
            'description' => ['nullable', 'string'],
            'field_of_study' => ['nullable', 'string', 'max:255'],
            'is_top' => ['sometimes', 'boolean'],
            'career_info' => ['nullable'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $program->update($data);

        return response()->json($program);
    }

    /**
     * Удаление программы.
     * DELETE /api/programs/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $program = Program::findOrFail($id);
        $program->delete();

        return response()->json(['message' => 'Program deleted successfully']);
    }
}

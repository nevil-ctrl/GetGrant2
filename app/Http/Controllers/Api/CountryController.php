<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country; // Используем предоставленную модель
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Для уникальности при обновлении

class CountryController extends Controller
{
    /**
     * 🗺️ Получение списка стран (Для фильтров).
     * GET /api/countries
     */
    public function index(): JsonResponse
    {
        // Выбираем только активные страны, сортируем и возвращаем только ID и NAME.
        $countries = Country::where('is_active', true)
            ->orderBy('name')
            // Ограничиваем поля для оптимизации и соответствия требованиям фильтра на фронте
            ->get(['id', 'name', 'flag']);

        // Возвращает чистый JSON-массив
        return response()->json($countries);
    }

    // --- Методы CRUD (если они нужны для админки) ---

    /**
     * Создание новой страны.
     * POST /api/countries
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:countries,name'],
            'code' => ['required', 'string', 'max:10', 'unique:countries,code'],
            'flag' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
            'selling_points' => ['nullable'], // Проверить формат, если JSON
        ]);

        $country = Country::create($data);

        return response()->json($country, 201); // 201 Created
    }

    /**
     * Отображение одной страны.
     * GET /api/countries/{id}
     */
    public function show(int $id): JsonResponse
    {
        // Автоматически вернет 404, если не найдено
        $country = Country::findOrFail($id);

        return response()->json($country);
    }

    /**
     * Обновление страны.
     * PUT/PATCH /api/countries/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $country = Country::findOrFail($id);

        $data = $request->validate([
            // Rule::unique для уникальности, игнорируя текущий ID
            'name' => ['sometimes', 'string', 'max:255', Rule::unique('countries')->ignore($id)],
            'code' => ['sometimes', 'string', 'max:10', Rule::unique('countries')->ignore($id)],
            'flag' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
            'selling_points' => ['nullable'],
        ]);

        $country->update($data);

        return response()->json($country);
    }

    /**
     * Удаление страны.
     * DELETE /api/countries/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $country = Country::findOrFail($id);
        $country->delete();

        return response()->json(['message' => 'Country deleted successfully']);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function __construct()
    {
        // Если хочешь тестировать без авторизации, можешь закомментировать auth
        // $this->middleware('auth:api')->except(['index', 'store']);
    }

    /**
     * Отображение списка всех документов
     */
    public function index()
    {
        $documents = Document::all();

        // Добавляем file_url для доступа через браузер
        $documents->transform(function ($doc) {
            $doc->file_url = $doc->file_path ? asset('storage/'.$doc->file_path) : null;

            return $doc;
        });

        return response()->json($documents);
    }

    /**
     * Загрузка нового документа
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'file_path' => 'required|file|mimes:pdf,jpg,png,txt|max:5120', // до 5 МБ
            'description' => 'nullable|string',
        ]);

        $file = $request->file('file_path');

        // Сохраняем файл в storage/app/public/documents
        $path = $file->store('documents', 'public');

        // Создаём запись в базе
        $document = Document::create([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'file_path' => $path,
            'is_active' => true,
        ]);

        // Добавляем публичный URL
        $document->file_url = asset('storage/'.$document->file_path);
        dd($request->all(), $request->file('file_path'));

        return response()->json($document, 201);

    }

    /**
     * Отображение конкретного документа
     */
    public function show($id)
    {
        $document = Document::findOrFail($id);
        $document->file_url = $document->file_path ? asset('storage/'.$document->file_path) : null;

        return response()->json($document);
    }

    /**
     * Обновление документа
     */
    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|string|max:50',
            'file_path' => 'sometimes|file|mimes:pdf,jpg,png,txt|max:5120',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        // Обновление файла, если пришёл новый
        if ($request->hasFile('file_path')) {
            // Удаляем старый файл
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $file = $request->file('file_path');
            $document->file_path = $file->store('documents', 'public');
        }

        // Обновление остальных полей
        $document->update($request->only(['name', 'type', 'description', 'is_active']));

        $document->file_url = $document->file_path ? asset('storage/'.$document->file_path) : null;

        return response()->json($document);
    }

    /**
     * Удаление документа
     */
    public function destroy($id)
    {
        $document = Document::findOrFail($id);

        // Удаляем файл с диска
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return response()->json(['message' => 'Документ успешно удалён.']);
    }
}

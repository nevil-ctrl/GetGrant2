<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = UserDocument::with(['user', 'document'])->get()->map(function ($doc) {
            $doc->file_url = $doc->file_path ? Storage::disk('public')->url($doc->file_path) : null;

            return $doc;
        });

        return response()->json($documents);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'application_id' => 'required|exists:applications,id',
            'type' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,png,docx',
            'status' => 'nullable|in:waiting,approved,rejected',
            'comment' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('user_documents', 'public');
        }

        $doc = UserDocument::create($validated);
        $doc->file_url = Storage::disk('public')->url($doc->file_path);

        return response()->json($doc, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doc = UserDocument::with(['user', 'document'])->findOrFail($id);
        $doc->file_url = $doc->file_path ? Storage::disk('public')->url($doc->file_path) : null;

        return response()->json($doc);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $doc = UserDocument::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'application_id' => 'sometimes|exists:applications,id',
            'type' => 'sometimes|string|max:255',
            'file' => 'nullable|file|mimes:pdf,jpg,png,docx',
            'status' => 'nullable|in:waiting,approved,rejected',
            'comment' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            if ($doc->file_path) {
                Storage::disk('public')->delete($doc->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('user_documents', 'public');
        }

        $doc->update($validated);
        $doc->file_url = $doc->file_path ? Storage::disk('public')->url($doc->file_path) : null;

        return response()->json($doc);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doc = UserDocument::findOrFail($id);
        if ($doc->file_path) {
            Storage::disk('public')->delete($doc->file_path);
        }
        $doc->delete();

        return response()->json(['message' => 'User document deleted successfully']);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return Message::with(['sender', 'receiver', 'application'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
            'application_id' => 'nullable|exists:applications,id',
            'message' => 'required|string',
        ]);

        return Message::create($validated);
    }

    public function show(string $id)
    {
        return Message::with(['sender', 'receiver', 'application'])->findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $message = Message::findOrFail($id);

        $validated = $request->validate([
            'sender_id' => 'sometimes|exists:users,id',
            'receiver_id' => 'sometimes|exists:users,id',
            'application_id' => 'nullable|exists:applications,id',
            'message' => 'sometimes|string',
        ]);

        $message->update($validated);

        return $message;
    }

    public function destroy(string $id)
    {
        return Message::destroy($id);
    }
}

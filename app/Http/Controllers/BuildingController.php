<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Lesson;
use App\Http\Middleware\CheckRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BuildingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(CheckRole::class.':manager,admin');
    }

    public function index()
    {
        $buildings = Building::with('lesson')->orderBy('name')->get();
        return view('buildings.index', compact('buildings'));
    }

    public function create()
    {
        $lessons = Lesson::where('user_id', Auth::id())->get();
        return view('buildings.create', compact('lessons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lesson_id' => ['nullable', 'exists:lessons,id'],
            'name' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('buildings', 'public');
        }

        Building::create($validated);

        return redirect()->route('buildings.index')
            ->with('success', 'Здание успешно создано');
    }

    public function show(Building $building)
    {
        $building->load('lesson', 'assignments');
        return view('buildings.show', compact('building'));
    }

    public function edit(Building $building)
    {
        $lessons = Lesson::where('user_id', Auth::id())->get();
        return view('buildings.edit', compact('building', 'lessons'));
    }

    public function update(Request $request, Building $building)
    {
        $validated = $request->validate([
            'lesson_id' => ['nullable', 'exists:lessons,id'],
            'name' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($building->image) {
                Storage::disk('public')->delete($building->image);
            }
            $validated['image'] = $request->file('image')->store('buildings', 'public');
        }

        $building->update($validated);

        return redirect()->route('buildings.index')
            ->with('success', 'Здание успешно обновлено');
    }

    public function destroy(Building $building)
    {
        if ($building->image) {
            Storage::disk('public')->delete($building->image);
        }
        $building->delete();

        return redirect()->route('buildings.index')
            ->with('success', 'Здание успешно удалено');
    }
}

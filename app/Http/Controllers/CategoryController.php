<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Category::where('is_active', true)
            ->with('lessons')
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        // Только менеджеры и админы могут создавать категории
        if (!Auth::user()->isManager() && !Auth::user()->isAdmin()) {
            abort(403);
        }
        
        return view('categories.create');
    }

    public function store(Request $request)
    {
        // Только менеджеры и админы могут создавать категории
        if (!Auth::user()->isManager() && !Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $validated['is_active'] ?? true;

        Category::create($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Категория успешно создана')
            ->with('active_tab', 'lessons');
    }

    public function show(Category $category)
    {
        $category->load(['lessons' => function ($query) {
            if (Auth::user()->isStudent()) {
                $query->where('is_published', true);
            }
            $query->orderBy('order');
        }]);

        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        // Только менеджеры и админы могут редактировать категории
        if (!Auth::user()->isManager() && !Auth::user()->isAdmin()) {
            abort(403);
        }
        
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        // Только менеджеры и админы могут редактировать категории
        if (!Auth::user()->isManager() && !Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Категория успешно обновлена')
            ->with('active_tab', 'lessons');
    }

    public function destroy(Category $category)
    {
        // Только менеджеры и админы могут удалять категории
        if (!Auth::user()->isManager() && !Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $category->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Категория успешно удалена')
            ->with('active_tab', 'lessons');
    }
}

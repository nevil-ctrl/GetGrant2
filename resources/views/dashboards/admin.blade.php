@extends('layouts.app', ['title' => 'Админ-панель'])

@section('content')
    <section class="container-custom py-10 space-y-8">
        <div class="space-y-2">
            <p class="text-sm text-[#6D7A89] uppercase tracking-wide">Администратор</p>
            <h1 class="text-3xl font-bold text-[#1A1A1A]">Панель управления</h1>
            <p class="text-sm text-[#6D7A89]">Управление всеми данными системы</p>
        </div>

        <div class="grid lg:grid-cols-4 gap-6">
            <!-- Статистика -->
            <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
                <h3 class="text-sm font-semibold text-[#6D7A89] mb-2">Пользователи</h3>
                <p class="text-3xl font-bold text-[#1A1A1A]">{{ \App\Models\User::count() }}</p>
                <p class="text-xs text-[#6D7A89] mt-1">
                    Студентов: {{ \App\Models\User::where('role', 'student')->count() }}<br>
                    Преподавателей: {{ \App\Models\User::where('role', 'teacher')->count() }}
                </p>
            </div>

            <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
                <h3 class="text-sm font-semibold text-[#6D7A89] mb-2">Курсы</h3>
                <p class="text-3xl font-bold text-[#1A1A1A]">{{ \App\Models\Course::count() }}</p>
                <p class="text-xs text-[#6D7A89] mt-1">
                    Активных: {{ \App\Models\Course::where('is_active', true)->count() }}
                </p>
            </div>

            <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
                <h3 class="text-sm font-semibold text-[#6D7A89] mb-2">Уроки</h3>
                <p class="text-3xl font-bold text-[#1A1A1A]">{{ \App\Models\Lesson::count() }}</p>
                <p class="text-xs text-[#6D7A89] mt-1">
                    Опубликовано: {{ \App\Models\Lesson::where('is_published', true)->count() }}
                </p>
            </div>

            <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
                <h3 class="text-sm font-semibold text-[#6D7A89] mb-2">Задания</h3>
                <p class="text-3xl font-bold text-[#1A1A1A]">{{ \App\Models\Assignment::count() }}</p>
                <p class="text-xs text-[#6D7A89] mt-1">
                    На проверке: {{ \App\Models\Assignment::where('status', 'submitted')->count() }}
                </p>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-6">
            <!-- Быстрые действия -->
            <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
                <h2 class="text-xl font-semibold text-[#1A1A1A] mb-4">Быстрые действия</h2>
                <div class="space-y-2">
                    <a href="/admin" class="block px-4 py-2 bg-[#1055b2] text-white rounded-lg hover:bg-[#003b8a] transition-colors text-sm font-semibold text-center">
                        Filament Admin Panel
                    </a>
                    <a href="{{ route('lessons.create') }}" class="block px-4 py-2 bg-gray-100 text-[#1A1A1A] rounded-lg hover:bg-gray-200 transition-colors text-sm font-semibold text-center">
                        Создать урок
                    </a>
                    <a href="{{ route('categories.create') }}" class="block px-4 py-2 bg-gray-100 text-[#1A1A1A] rounded-lg hover:bg-gray-200 transition-colors text-sm font-semibold text-center">
                        Создать категорию
                    </a>
                </div>
            </div>

            <!-- Последние действия -->
            <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
                <h2 class="text-xl font-semibold text-[#1A1A1A] mb-4">Последние уроки</h2>
                @php
                    $recentLessons = \App\Models\Lesson::with(['course', 'category', 'user'])
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
                @endphp
                @if($recentLessons->count() > 0)
                    <div class="space-y-2">
                        @foreach($recentLessons as $lesson)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-medium text-[#1A1A1A]">{{ $lesson->title ?? 'Урок #' . $lesson->id }}</p>
                                    <p class="text-xs text-[#6D7A89]">{{ $lesson->user->name ?? 'Неизвестно' }}</p>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full {{ $lesson->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $lesson->is_published ? 'Опубликован' : 'Черновик' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-[#6D7A89]">Нет уроков</p>
                @endif
            </div>
        </div>
    </section>
@endsection

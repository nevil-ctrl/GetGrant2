@extends('layouts.app', ['title' => 'Проверка задания: ' . $assignment->title])

@section('content')
<div class="container-custom py-6">
    <!-- Breadcrumbs -->
    <nav class="mb-4 text-sm text-[#6D7A89]">
        <a href="{{ route('dashboard') }}" class="hover:text-[#1055b2]">Дашборд</a>
        <span class="mx-2">/</span>
        <a href="{{ route('dashboard') }}?tab=assignments" class="hover:text-[#1055b2]">Задания</a>
        <span class="mx-2">/</span>
        <span class="text-[#1A1A1A]">Проверка</span>
    </nav>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
            <h1 class="text-2xl font-bold text-[#1A1A1A] mb-6">Проверка задания</h1>

            <!-- Информация о задании -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold text-[#1A1A1A] mb-2">{{ $assignment->title }}</h2>
                <p class="text-sm text-[#6D7A89] mb-2">
                    Студент: <span class="font-semibold text-[#1A1A1A]">{{ $assignment->user->name }}</span>
                </p>
                @if($assignment->lesson)
                    <p class="text-sm text-[#6D7A89]">
                        Урок: <a href="{{ route('lessons.show', $assignment->lesson->id) }}" 
                                 class="text-[#1055b2] hover:text-[#003b8a]">{{ $assignment->lesson->title }}</a>
                    </p>
                @endif
                @if($assignment->submitted_at)
                    <p class="text-sm text-[#6D7A89] mt-2">
                        Отправлено: {{ $assignment->submitted_at->format('d.m.Y H:i') }}
                    </p>
                @endif
            </div>

            <!-- Условие задания -->
            @if($assignment->description)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-[#1A1A1A] mb-2">Условие задания</h3>
                    <div class="prose max-w-none text-[#1A1A1A]">
                        {!! nl2br(e($assignment->description)) !!}
                    </div>
                </div>
            @endif

            <!-- Работа студента -->
            @if($assignment->submission_link)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-[#1A1A1A] mb-2">Работа студента</h3>
                    <a href="{{ $assignment->submission_link }}" target="_blank" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-[#1055b2] text-white rounded-lg hover:bg-[#003b8a] transition-colors mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Просмотреть работу
                    </a>
                    <p class="text-sm text-[#6D7A89] break-all">{{ $assignment->submission_link }}</p>
                </div>
            @endif

            <!-- Комментарий студента (если есть) -->
            @if($assignment->student_comment)
                <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="text-sm font-semibold text-[#1055b2] mb-2">Комментарий студента:</h3>
                    <p class="text-sm text-[#1A1A1A]">{{ $assignment->student_comment }}</p>
                </div>
            @endif

            <!-- Форма проверки -->
            <form action="{{ route('assignments.review.store', $assignment->id) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-[#1A1A1A] mb-2">
                        Результат проверки
                    </label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="approved" class="w-4 h-4 text-green-600" required>
                            <span class="text-sm text-[#1A1A1A]">Одобрено</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="rejected" class="w-4 h-4 text-red-600" required>
                            <span class="text-sm text-[#1A1A1A]">Отклонено</span>
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-[#1A1A1A] mb-2">
                        Комментарий преподавателя
                    </label>
                    <textarea name="teacher_comment" 
                              rows="6"
                              placeholder="Оставьте комментарий о работе студента..."
                              class="w-full px-4 py-2 border border-border rounded-lg focus:ring-2 focus:ring-[#1055b2] focus:border-[#1055b2]">{{ old('teacher_comment') }}</textarea>
                    @error('teacher_comment')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit" 
                            class="px-6 py-3 bg-[#1055b2] text-white rounded-lg hover:bg-[#003b8a] transition-colors font-semibold">
                        Сохранить проверку
                    </button>
                    <a href="{{ route('assignments.show', $assignment->id) }}" 
                       class="px-6 py-3 border border-border text-[#1A1A1A] rounded-lg hover:bg-gray-50 transition-colors font-semibold">
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

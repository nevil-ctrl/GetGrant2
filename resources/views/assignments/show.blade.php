@extends('layouts.app', ['title' => $assignment->title])

@section('content')
<div class="container-custom py-6">
    <!-- Breadcrumbs -->
    <nav class="mb-4 text-sm text-[#6D7A89]">
        <a href="{{ route('dashboard') }}" class="hover:text-[#1055b2]">Дашборд</a>
        <span class="mx-2">/</span>
        <a href="{{ route('dashboard') }}?tab=assignments" class="hover:text-[#1055b2]">Задания</a>
        <span class="mx-2">/</span>
        <span class="text-[#1A1A1A]">{{ $assignment->title }}</span>
    </nav>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-[#1A1A1A] mb-2">{{ $assignment->title }}</h1>
                    @if($assignment->lesson)
                        <p class="text-sm text-[#6D7A89]">
                            Урок: <a href="{{ route('lessons.show', $assignment->lesson->id) }}" 
                                     class="text-[#1055b2] hover:text-[#003b8a]">{{ $assignment->lesson->title }}</a>
                        </p>
                    @endif
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                    @if($assignment->status === 'approved') bg-green-100 text-green-700
                    @elseif($assignment->status === 'rejected') bg-red-100 text-red-700
                    @elseif($assignment->status === 'submitted') bg-yellow-100 text-yellow-700
                    @else bg-gray-100 text-gray-700
                    @endif">
                    @if($assignment->status === 'pending') Ожидает
                    @elseif($assignment->status === 'submitted') На проверке
                    @elseif($assignment->status === 'approved') Одобрено
                    @elseif($assignment->status === 'rejected') Отклонено
                    @endif
                </span>
            </div>

            <!-- Условие задания -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                <h2 class="text-lg font-semibold text-[#1A1A1A] mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#1055b2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Условие задания
                </h2>
                
                @if($assignment->description)
                    <div class="prose max-w-none text-[#1A1A1A]">
                        {!! nl2br(e($assignment->description)) !!}
                    </div>
                @endif

                @if($assignment->due_date)
                    <div class="mt-4 p-3 bg-white rounded-lg">
                        <p class="text-sm font-semibold text-[#1A1A1A]">Срок сдачи:</p>
                        <p class="text-sm text-[#6D7A89]">{{ $assignment->due_date->format('d.m.Y H:i') }}</p>
                    </div>
                @endif
            </div>

            <!-- Работа проверена (если статус approved/rejected) -->
            @if($assignment->status === 'approved' || $assignment->status === 'reviewed')
                <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                    <h2 class="text-lg font-semibold text-[#1A1A1A] mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Работа проверена
                    </h2>
                    <p class="text-sm text-[#6D7A89] mb-4">Преподаватель оценил вашу работу</p>
                    
                    @if($assignment->submission_link)
                        <div class="mb-4">
                            <p class="text-sm font-semibold text-[#1A1A1A] mb-2">Ваша работа:</p>
                            <a href="{{ $assignment->submission_link }}" target="_blank" 
                               class="inline-flex items-center gap-2 text-sm text-[#1055b2] hover:text-[#003b8a] break-all">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                {{ $assignment->submission_link }}
                            </a>
                        </div>
                    @endif

                    @if($assignment->student_comment)
                        <div class="mt-4">
                            <p class="text-sm font-semibold text-[#1A1A1A] mb-2">Ваш комментарий:</p>
                            <p class="text-sm text-[#1A1A1A] bg-white p-3 rounded-lg">{{ $assignment->student_comment }}</p>
                        </div>
                    @endif

                    @if($assignment->teacher_comment)
                        <div class="mt-4">
                            <p class="text-sm font-semibold text-[#1A1A1A] mb-2">Комментарий преподавателя:</p>
                            <p class="text-sm text-[#1A1A1A] bg-white p-3 rounded-lg">{{ $assignment->teacher_comment }}</p>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Форма сдачи задания (для студентов) -->
            @if(auth()->user()->isStudent() && ($assignment->status === 'pending' || $assignment->status === null))
                <div class="bg-white border border-border/60 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-[#1A1A1A] mb-4">Сдать задание</h2>
                    
                    <form action="{{ route('assignments.submit', $assignment->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-[#1A1A1A] mb-2">
                                Ссылка на работу (GitHub, Google Drive и т.д.)
                            </label>
                            <input type="url" 
                                   name="submission_link" 
                                   value="{{ old('submission_link', $assignment->submission_link) }}"
                                   placeholder="https://github.com/username/repo или https://drive.google.com/..."
                                   class="w-full px-4 py-2 border border-border rounded-lg focus:ring-2 focus:ring-[#1055b2] focus:border-[#1055b2]"
                                   required>
                            @error('submission_link')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-[#1A1A1A] mb-2">
                                Комментарий (опционально)
                            </label>
                            <textarea name="comment" 
                                      rows="4"
                                      placeholder="Опишите что вы сделали, какие технологии использовали и т.д."
                                      class="w-full px-4 py-2 border border-border rounded-lg focus:ring-2 focus:ring-[#1055b2] focus:border-[#1055b2]">{{ old('comment') }}</textarea>
                        </div>

                        <button type="submit" 
                                class="w-full px-6 py-3 bg-[#1055b2] text-white rounded-lg hover:bg-[#003b8a] transition-colors font-semibold">
                            Отправить на проверку
                        </button>
                    </form>
                </div>
            @endif

            <!-- Просмотр работы (для менеджеров) -->
            @if((auth()->user()->isManager() || auth()->user()->isAdmin()) && $assignment->submission_link)
                <div class="bg-white border border-border/60 rounded-lg p-6 mt-6">
                    <h2 class="text-lg font-semibold text-[#1A1A1A] mb-4">Работа студента</h2>
                    <a href="{{ $assignment->submission_link }}" target="_blank" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-[#1055b2] text-white rounded-lg hover:bg-[#003b8a] transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Просмотреть работу
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

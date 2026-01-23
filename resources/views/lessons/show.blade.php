@extends('layouts.app', ['title' => $lesson->title])

@section('content')
<div class="container-custom py-6">
    <!-- Breadcrumbs -->
    <nav class="mb-4 text-sm text-[#6D7A89]">
        <a href="{{ route('dashboard') }}" class="hover:text-[#1055b2]">Дашборд</a>
        <span class="mx-2">/</span>
        <a href="{{ route('dashboard') }}?tab=lessons" class="hover:text-[#1055b2]">Уроки</a>
        <span class="mx-2">/</span>
        <span class="text-[#1A1A1A]">{{ $lesson->title }}</span>
    </nav>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Левая панель: Список уроков в категории -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-4 sticky top-4">
                <h3 class="font-semibold text-[#1A1A1A] mb-4">
                    @if($lesson->category)
                        {{ $lesson->category->name }}
                    @else
                        Уроки
                    @endif
                </h3>
                
                @php
                    $relatedLessons = \App\Models\Lesson::where('category_id', $lesson->category_id)
                        ->where('is_published', true)
                        ->orderBy('order')
                        ->get();
                @endphp
                
                <div class="space-y-2">
                    @foreach($relatedLessons as $relatedLesson)
                        <a href="{{ route('lessons.show', $relatedLesson->id) }}" 
                           class="block p-3 rounded-lg transition-colors {{ $relatedLesson->id === $lesson->id ? 'bg-[#1055b2]/10 border border-[#1055b2]/20' : 'hover:bg-gray-50' }}">
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-[#6D7A89]">{{ $loop->iteration }}.</span>
                                <span class="text-sm font-medium text-[#1A1A1A]">{{ $relatedLesson->title }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Правая панель: Контент урока -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
                <h1 class="text-2xl font-bold text-[#1A1A1A] mb-4">{{ $lesson->title }}</h1>
                
                @if($lesson->description)
                    <div class="prose max-w-none mb-6">
                        {!! $lesson->description !!}
                    </div>
                @endif

                <!-- Видео с YouTube -->
                @if($lesson->video_url)
                    <div class="mb-6">
                        <div class="relative w-full bg-black rounded-lg overflow-hidden" style="padding-bottom: 56.25%;">
                            @php
                                // Преобразуем URL YouTube в embed формат
                                $embedUrl = $lesson->video_url;
                                if (str_contains($embedUrl, 'youtube.com/watch?v=')) {
                                    $videoId = parse_str(parse_url($embedUrl, PHP_URL_QUERY), $params);
                                    $videoId = $params['v'] ?? null;
                                    $embedUrl = $videoId ? "https://www.youtube.com/embed/{$videoId}" : $embedUrl;
                                } elseif (str_contains($embedUrl, 'youtu.be/')) {
                                    $videoId = basename(parse_url($embedUrl, PHP_URL_PATH));
                                    $embedUrl = "https://www.youtube.com/embed/{$videoId}";
                                } elseif (!str_contains($embedUrl, 'embed')) {
                                    $embedUrl = str_replace('watch?v=', 'embed/', $embedUrl);
                                }
                            @endphp
                            <iframe 
                                class="absolute top-0 left-0 w-full h-full"
                                src="{{ $embedUrl }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                        <div class="mt-3 flex gap-3">
                            <a href="{{ $lesson->video_url }}" target="_blank" 
                               class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                                Посмотреть на YouTube
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Задания к уроку -->
                @if($lesson->assignments->count() > 0)
                    <div class="mt-8 border-t border-border/60 pt-6">
                        <h2 class="text-xl font-semibold text-[#1A1A1A] mb-4">Задания к уроку</h2>
                        <div class="space-y-4">
                            @foreach($lesson->assignments as $assignment)
                                <div class="border border-border/60 rounded-lg p-4">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <h3 class="font-semibold text-[#1A1A1A]">{{ $assignment->title }}</h3>
                                            @if($assignment->description)
                                                <p class="text-sm text-[#6D7A89] mt-1">{{ $assignment->description }}</p>
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
                                    
                                    @if($assignment->due_date)
                                        <p class="text-xs text-[#6D7A89] mb-3">
                                            Срок сдачи: {{ $assignment->due_date->format('d.m.Y') }}
                                        </p>
                                    @endif

                                    @if($assignment->submission_link)
                                        <div class="mb-3">
                                            <a href="{{ $assignment->submission_link }}" target="_blank" 
                                               class="inline-flex items-center gap-2 text-sm text-[#1055b2] hover:text-[#003b8a]">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                </svg>
                                                {{ $assignment->submission_link }}
                                            </a>
                                        </div>
                                    @endif

                                    @if($assignment->teacher_comment)
                                        <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                                            <p class="text-xs font-semibold text-[#1055b2] mb-1">Комментарий преподавателя:</p>
                                            <p class="text-sm text-[#1A1A1A]">{{ $assignment->teacher_comment }}</p>
                                        </div>
                                    @endif

                                    @if($assignment->status === 'pending' || $assignment->status === null)
                                        <a href="{{ route('assignments.show', $assignment->id) }}" 
                                           class="inline-block mt-3 px-4 py-2 bg-[#1055b2] text-white rounded-lg hover:bg-[#003b8a] transition-colors text-sm font-semibold">
                                            Выполнить задание
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

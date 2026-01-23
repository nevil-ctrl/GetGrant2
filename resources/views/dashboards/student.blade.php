@extends('layouts.app', ['title' => 'Личный кабинет студента'])

@section('content')
    <section class="container-custom py-10 space-y-8">
        <div class="space-y-2">
            <p class="text-sm text-[#6D7A89] uppercase tracking-wide">Личный кабинет</p>
            <h1 class="text-3xl font-bold text-[#1A1A1A]">Привет, {{ $user->name }}!</h1>
            <p class="text-sm text-[#6D7A89]">Изучайте курсы, выполняйте задания и отслеживайте прогресс</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <!-- Курсы по категориям -->
                @if($categories->count() > 0)
                    @foreach($categories as $category)
                        <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
                            <h2 class="text-xl font-semibold text-[#1A1A1A] mb-4">{{ $category->name }}</h2>
                            @if($category->description)
                                <p class="text-sm text-[#6D7A89] mb-4">{{ $category->description }}</p>
                            @endif
                            
                            <div class="grid md:grid-cols-2 gap-4">
                                @foreach($category->lessons as $lesson)
                                    @include('partials.lesson-card', ['lesson' => $lesson, 'user' => $user])
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
                        <p class="text-[#6D7A89]">Пока нет доступных уроков</p>
                    </div>
                @endif

                <!-- Мои задания -->
                <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-[#1A1A1A] mb-4">Мои задания</h2>
                    @if($assignments->count() > 0)
                        <div class="space-y-3">
                            @foreach($assignments as $assignment)
                                @include('partials.assignment-card', ['assignment' => $assignment])
                            @endforeach
                    </div>
                    @else
                        <p class="text-[#6D7A89]">У вас пока нет заданий</p>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <!-- Статистика -->
                <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-[#1A1A1A] mb-4">Статистика</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-[#6D7A89]">Пройдено уроков</span>
                            <span class="text-sm font-semibold text-[#1A1A1A]">{{ $assignments->where('status', 'approved')->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-[#6D7A89]">На проверке</span>
                            <span class="text-sm font-semibold text-[#1A1A1A]">{{ $assignments->where('status', 'submitted')->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-[#6D7A89]">Всего заданий</span>
                            <span class="text-sm font-semibold text-[#1A1A1A]">{{ $assignments->count() }}</span>
                    </div>
                    </div>
                </div>

                <!-- Последние уроки -->
                @if($recentLessons->count() > 0)
                    <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-[#1A1A1A] mb-4">Последние уроки</h3>
                        <div class="space-y-3">
                            @foreach($recentLessons as $lesson)
                                <a href="{{ route('lessons.show', $lesson->id) }}" class="block p-3 rounded-lg hover:bg-gray-50 transition-colors">
                                    <p class="text-sm font-medium text-[#1A1A1A]">{{ $lesson->title ?? 'Урок #' . $lesson->id }}</p>
                                    <p class="text-xs text-[#6D7A89] mt-1">{{ $lesson->course->name ?? '' }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @vite('resources/js/widgets.tsx')
@endpush

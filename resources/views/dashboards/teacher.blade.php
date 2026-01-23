@extends('layouts.app', ['title' => 'Кабинет преподавателя'])

@section('content')
    <section class="container-custom py-10 space-y-8">
        <div class="space-y-2">
            <p class="text-sm text-[#6D7A89] uppercase tracking-wide">Преподаватель</p>
            <h1 class="text-3xl font-bold text-[#1A1A1A]">Здравствуйте, {{ $user->name }}!</h1>
            <p class="text-sm text-[#6D7A89]">Управляйте уроками, заданиями и проверяйте работы студентов</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <!-- Мои уроки -->
                <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-[#1A1A1A]">Мои уроки</h2>
                        <a href="{{ route('lessons.create') }}" class="px-4 py-2 bg-[#1055b2] text-white rounded-lg hover:bg-[#003b8a] transition-colors text-sm font-semibold">
                            + Создать урок
                        </a>
                    </div>
                    
                    @if($courses->count() > 0)
                        <div class="space-y-4">
                            @foreach($courses as $course)
                                <div class="border border-border/60 rounded-lg p-4">
                                    <h3 class="font-semibold text-[#1A1A1A] mb-2">{{ $course->name }}</h3>
                                    @if($course->lessons->count() > 0)
                                        <div class="space-y-2">
                                            @foreach($course->lessons as $lesson)
                                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                                    <div>
                                                        <p class="text-sm font-medium text-[#1A1A1A]">{{ $lesson->title ?? 'Урок #' . $lesson->id }}</p>
                                                        <p class="text-xs text-[#6D7A89]">
                                                            {{ $lesson->is_published ? 'Опубликован' : 'Черновик' }}
                                                            @if($lesson->category)
                                                                • {{ $lesson->category->name }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="flex gap-2">
                                                        <a href="{{ route('lessons.edit', $lesson->id) }}" class="text-sm text-[#1055b2] hover:text-[#003b8a]">Редактировать</a>
                                                        <a href="{{ route('lessons.assignments', $lesson->id) }}" class="text-sm text-[#1055b2] hover:text-[#003b8a]">Задания</a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-[#6D7A89]">Нет уроков в этом курсе</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-[#6D7A89]">У вас пока нет уроков. Создайте первый урок!</p>
                    @endif
                </div>

                <!-- Задания на проверку -->
                <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-[#1A1A1A] mb-4">Задания на проверку</h2>
                    @php
                        $pendingAssignments = \App\Models\Assignment::whereHas('lesson', function($query) use ($user) {
                            $query->where('user_id', $user->id);
                        })
                        ->where('status', 'submitted')
                        ->with(['user', 'lesson'])
                        ->orderBy('submitted_at', 'desc')
                        ->get();
                    @endphp
                    
                    @if($pendingAssignments->count() > 0)
                        <div class="space-y-3">
                            @foreach($pendingAssignments as $assignment)
                                @include('partials.assignment-review-card', ['assignment' => $assignment])
                            @endforeach
                        </div>
                    @else
                        <p class="text-[#6D7A89]">Нет заданий на проверку</p>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <!-- Статистика -->
                <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-[#1A1A1A] mb-4">Статистика</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-[#6D7A89]">Всего уроков</span>
                            <span class="text-sm font-semibold text-[#1A1A1A]">{{ $courses->sum(fn($c) => $c->lessons->count()) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-[#6D7A89]">Опубликовано</span>
                            <span class="text-sm font-semibold text-[#1A1A1A]">{{ $courses->sum(fn($c) => $c->lessons->where('is_published', true)->count()) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-[#6D7A89]">На проверке</span>
                            <span class="text-sm font-semibold text-[#1A1A1A]">{{ $pendingAssignments->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Студенты -->
                @if($students->count() > 0)
                    <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-[#1A1A1A] mb-4">Студенты</h3>
                        <div class="space-y-2">
                            @foreach($students->take(5) as $student)
                                <div class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50">
                                    <div>
                                        <p class="text-sm font-medium text-[#1A1A1A]">{{ $student->name }}</p>
                                        <p class="text-xs text-[#6D7A89]">{{ $student->email }}</p>
                                    </div>
                                    <span class="text-xs text-[#6D7A89]">
                                        {{ $student->assignments->where('status', 'submitted')->count() }} на проверке
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

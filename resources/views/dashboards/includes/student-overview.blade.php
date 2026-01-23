<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <!-- Статистика -->
        <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
            <h2 class="text-xl font-semibold text-[#1A1A1A] mb-4">Моя статистика</h2>
            <div class="grid md:grid-cols-3 gap-4">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <p class="text-2xl font-bold text-[#1055b2]">{{ $assignments->where('status', 'approved')->count() }}</p>
                    <p class="text-sm text-[#6D7A89] mt-1">Пройдено уроков</p>
                </div>
                <div class="text-center p-4 bg-yellow-50 rounded-lg">
                    <p class="text-2xl font-bold text-yellow-600">{{ $assignments->where('status', 'submitted')->count() }}</p>
                    <p class="text-sm text-[#6D7A89] mt-1">На проверке</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-[#1A1A1A]">{{ $assignments->count() }}</p>
                    <p class="text-sm text-[#6D7A89] mt-1">Всего заданий</p>
                </div>
            </div>
        </div>

        <!-- Менеджер -->
        @if($user->manager)
            <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
                <h2 class="text-xl font-semibold text-[#1A1A1A] mb-4">Ваш менеджер</h2>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-lg font-semibold text-[#1A1A1A]">{{ $user->manager->name }}</p>
                        <p class="text-sm text-[#6D7A89]">{{ $user->manager->email }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-[#1055b2]/15 text-[#1055b2] text-xs font-semibold">
                        Онлайн
                    </span>
                </div>
            </div>
        @endif
    </div>

    <div class="space-y-6">
        <!-- Последние уроки -->
        @if(isset($recentLessons) && $recentLessons->count() > 0)
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

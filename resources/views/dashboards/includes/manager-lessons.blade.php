<div class="space-y-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-semibold text-[#1A1A1A]">Мои уроки</h2>
        <a href="{{ route('lessons.create') }}" class="px-4 py-2 bg-[#1055b2] text-white rounded-lg hover:bg-[#003b8a] transition-colors text-sm font-semibold">
            + Создать урок
        </a>
    </div>

    @if(isset($categories) && $categories->count() > 0)
        @foreach($categories as $category)
            <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
                <h3 class="text-lg font-semibold text-[#1A1A1A] mb-4">{{ $category->name }}</h3>
                @if($category->lessons->count() > 0)
                    <div class="space-y-2">
                        @foreach($category->lessons as $lesson)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-medium text-[#1A1A1A]">{{ $lesson->title ?? 'Урок #' . $lesson->id }}</p>
                                    <p class="text-xs text-[#6D7A89]">
                                        {{ $lesson->is_published ? 'Опубликован' : 'Черновик' }}
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
                    <p class="text-sm text-[#6D7A89]">Нет уроков в этой категории</p>
                @endif
            </div>
        @endforeach
    @else
        <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
            <p class="text-[#6D7A89]">У вас пока нет уроков. Создайте первый урок!</p>
        </div>
    @endif
</div>

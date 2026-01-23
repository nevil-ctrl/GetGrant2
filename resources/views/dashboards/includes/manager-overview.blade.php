<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <!-- Статистика -->
        <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
            <h2 class="text-xl font-semibold text-[#1A1A1A] mb-4">Статистика</h2>
            <div class="grid md:grid-cols-3 gap-4">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <p class="text-2xl font-bold text-[#1055b2]">{{ isset($students) ? $students->count() : 0 }}</p>
                    <p class="text-sm text-[#6D7A89] mt-1">Студентов</p>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <p class="text-2xl font-bold text-green-600">{{ isset($courses) ? $courses->sum(fn($c) => $c->lessons->count()) : 0 }}</p>
                    <p class="text-sm text-[#6D7A89] mt-1">Уроков</p>
                </div>
                <div class="text-center p-4 bg-yellow-50 rounded-lg">
                    <p class="text-2xl font-bold text-yellow-600">{{ isset($pendingAssignments) ? $pendingAssignments->count() : 0 }}</p>
                    <p class="text-sm text-[#6D7A89] mt-1">На проверке</p>
                </div>
            </div>
        </div>

        <!-- Быстрые действия -->
        <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
            <h2 class="text-xl font-semibold text-[#1A1A1A] mb-4">Быстрые действия</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <a href="{{ route('lessons.create') }}" class="p-4 border border-border/60 rounded-lg hover:bg-gray-50 transition-colors">
                    <p class="font-semibold text-[#1A1A1A]">Создать урок</p>
                    <p class="text-sm text-[#6D7A89] mt-1">Добавить новый видео-урок</p>
                </a>
                <a href="{{ route('categories.create') }}" class="p-4 border border-border/60 rounded-lg hover:bg-gray-50 transition-colors">
                    <p class="font-semibold text-[#1A1A1A]">Создать категорию</p>
                    <p class="text-sm text-[#6D7A89] mt-1">Добавить новую категорию</p>
                </a>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <!-- Последние студенты -->
        @if(isset($students) && $students->count() > 0)
            <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
                <h3 class="text-lg font-semibold text-[#1A1A1A] mb-4">Мои студенты</h3>
                <div class="space-y-2">
                    @foreach($students->take(5) as $student)
                        <div class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50">
                            <div>
                                <p class="text-sm font-medium text-[#1A1A1A]">{{ $student->name }}</p>
                                <p class="text-xs text-[#6D7A89]">{{ $student->email }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

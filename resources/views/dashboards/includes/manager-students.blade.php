<div class="space-y-6">
    <h2 class="text-2xl font-semibold text-[#1A1A1A] mb-4">Мои студенты</h2>
    
    @if(isset($students) && $students->count() > 0)
        <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
            <div class="space-y-4">
                @foreach($students as $student)
                    <div class="flex items-center justify-between p-4 border border-border/60 rounded-lg">
                        <div class="flex-1">
                            <p class="font-semibold text-[#1A1A1A]">{{ $student->name }}</p>
                            <p class="text-sm text-[#6D7A89]">{{ $student->email }}</p>
                            @if($student->applications->count() > 0)
                                <p class="text-xs text-[#6D7A89] mt-1">
                                    Статус: {{ $student->applications->first()->status ?? 'Нет данных' }}
                                </p>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('dashboard') }}?tab=students&student={{ $student->id }}" class="text-sm text-[#1055b2] hover:text-[#003b8a]">
                                Подробнее
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-white rounded-2xl border border-border/60 shadow-sm p-6">
            <p class="text-[#6D7A89]">У вас пока нет студентов</p>
        </div>
    @endif
</div>

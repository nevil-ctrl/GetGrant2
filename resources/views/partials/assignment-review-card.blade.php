<div class="border border-border/60 rounded-lg p-4">
    <div class="flex items-start justify-between mb-2">
        <div>
            <h3 class="font-semibold text-[#1A1A1A]">{{ $assignment->title }}</h3>
            <p class="text-sm text-[#6D7A89]">
                Студент: {{ $assignment->user->name }}
            </p>
            @if($assignment->lesson)
                <p class="text-xs text-[#6D7A89]">Урок: {{ $assignment->lesson->title ?? 'Урок #' . $assignment->lesson->id }}</p>
            @endif
        </div>
        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
            На проверке
        </span>
    </div>
    
    @if($assignment->description)
        <p class="text-sm text-[#6D7A89] mb-3">{{ $assignment->description }}</p>
    @endif
    
    @if($assignment->submission_link)
        <div class="mb-3">
            <a href="{{ $assignment->submission_link }}" target="_blank" class="text-sm text-[#1055b2] hover:text-[#003b8a] flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                Ссылка на выполнение
            </a>
        </div>
    @endif
    
    @if($assignment->submitted_at)
        <p class="text-xs text-[#6D7A89] mb-3">Отправлено: {{ $assignment->submitted_at->format('d.m.Y H:i') }}</p>
    @endif
    
    <div class="flex gap-2 mt-3">
        <a href="{{ route('assignments.review', $assignment->id) }}" class="px-4 py-2 bg-[#1055b2] text-white rounded-lg hover:bg-[#003b8a] transition-colors text-sm font-semibold">
            Проверить
        </a>
    </div>
</div>

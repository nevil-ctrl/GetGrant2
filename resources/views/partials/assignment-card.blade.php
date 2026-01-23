<div class="border border-border/60 rounded-lg p-4">
    <div class="flex items-start justify-between mb-2">
        <div>
            <h3 class="font-semibold text-[#1A1A1A]">{{ $assignment->title }}</h3>
            @if($assignment->lesson)
                <p class="text-sm text-[#6D7A89]">Урок: {{ $assignment->lesson->title ?? 'Урок #' . $assignment->lesson->id }}</p>
            @endif
        </div>
        <span class="px-2 py-1 rounded-full text-xs font-semibold
            @if($assignment->status === 'approved') bg-green-100 text-green-700
            @elseif($assignment->status === 'rejected') bg-red-100 text-red-700
            @elseif($assignment->status === 'submitted') bg-yellow-100 text-yellow-700
            @else bg-gray-100 text-gray-700
            @endif">
            @if($assignment->status === 'pending') Ожидает
            @elseif($assignment->status === 'submitted') На проверке
            @elseif($assignment->status === 'reviewed') Проверено
            @elseif($assignment->status === 'approved') Одобрено
            @elseif($assignment->status === 'rejected') Отклонено
            @endif
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
    
    @if($assignment->teacher_comment)
        <div class="mt-3 p-3 bg-blue-50 rounded-lg">
            <p class="text-xs font-semibold text-[#1055b2] mb-1">Комментарий преподавателя:</p>
            <p class="text-sm text-[#1A1A1A]">{{ $assignment->teacher_comment }}</p>
        </div>
    @endif
    
    @if($assignment->status === 'pending' || $assignment->status === null)
        <div class="mt-3">
            <a href="{{ route('assignments.show', $assignment->id) }}" 
               class="inline-block px-4 py-2 bg-[#1055b2] text-white rounded-lg hover:bg-[#003b8a] transition-colors text-sm font-semibold">
                Выполнить задание
            </a>
        </div>
    @else
        <div class="mt-3">
            <a href="{{ route('assignments.show', $assignment->id) }}" 
               class="inline-block px-4 py-2 border border-[#1055b2] text-[#1055b2] rounded-lg hover:bg-[#1055b2]/10 transition-colors text-sm font-semibold">
                Просмотреть задание
            </a>
        </div>
    @endif
</div>
